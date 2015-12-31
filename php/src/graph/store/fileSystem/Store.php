<?php
namespace Comode\graph\store\fileSystem;

use Comode\graph\store\IStore;

class Store implements IStore {

    private $nodeStore;
    private $valueStore;

    public function __construct(
        node\IStore $nodeStore, 
        value\IStore $valueStore
    ) {
        $this->nodeStore = $nodeStore;
        $this->valueStore = $valueStore;
    }

    public function nodeExists($nodeId)
    {
        return $this->nodeStore->directory($nodeId)->exists();
    }
    
    public function createNode($value = '')
    {
        // read node by value
        if (strlen($value) > 0) {
            $nodeId = $this->valueStore->getNode($value);
            if (!is_null($nodeId)) {
                return $nodeId;
            }
        }

        // create new node
        $nodeId = $this->nodeStore->create();

        if (strlen($value) > 0) {
            // bind value to new node
            $valueHash = $this->valueStore->create($value);
            $this->nodeStore->bindValue($nodeId, $this->valueStore->directory($valueHash));
            $this->valueStore->bindNode($valueHash, $this->nodeStore->directory($nodeId));
        }

        return $nodeId;
    }

    public function linkNodes($fromId, $toId)
    {
        $fromDirectory = $this->nodeStore->directory($fromId);
        $link = $fromDirectory->link($toId);

        if (!$link->exists()) {
            
            $toDirectory = $this->nodeStore->directory($toId);
            $link->create($toDirectory->path());
            
        }
    }
    
    public function separateNodes($fromId, $toId)
    {
        $fromDirectory = $this->nodeStore->directory($fromId);
        $link = $fromDirectory->link($toId);

        if ($link->exists()) {
            
            $link->delete();
            
        }
    }
        
    public function isLinkedToNode($fromId, $toId)
    {
        $fromDirectory = $this->nodeStore->directory($fromId);
        $link = $fromDirectory->directory($toId);

        return $link->exists();
    }
    
    public function getLinkedNodes($nodeId)
    {
        $nodeDirectory = $this->nodeStore->directory($nodeId);

        $nodeIds = $nodeDirectory->names();

        return $nodeIds;
    }

    public function getValueNode($value)
    {
        return $this->valueStore->getNode($value);
    }
        
    public function getNodeValue($nodeId)
    {
        list($isFile, $content) = $this->nodeStore->getValue($nodeId);
        
        return new Value($isFile, $content);
    }
}
