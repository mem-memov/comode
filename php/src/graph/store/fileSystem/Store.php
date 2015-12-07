<?php
namespace Comode\graph\store\fileSystem;

use Comode\graph\store\IStore;
use Comode\graph\store\Value;
use Comode\graph\store\IValue;

class Store implements IStore {

    private $nodeStore;
    private $valueStore;

    public function __construct(
        INodeStore $nodeStore, 
        IValueStore $valueStore
    ) {
        $this->nodeStore = $nodeStore;
        $this->valueStore = $valueStore;
    }

    public function nodeExists($nodeId)
    {
        return $this->nodeStore->directory($nodeId)->exists();
    }
    
    public function createNode(array $structure = [])
    {
        // read node by value
        if (!empty($structure)) {
            $nodeId = $this->valueStore->getNode($structure);
            if (!is_null($nodeId)) {
                return $nodeId;
            }
        }

        // create new node
        $nodeId = $this->nodeStore->create();

        if (!empty($structure)) {
            // bind value to new node
            $valueHash = $this->valueStore->create($structure);
            $this->nodeStore->bindValue($nodeId, $this->valueStore->directory($valueHash));
            $this->valueStore->bindNode($valueHash, $this->nodeStore->directory($nodeId));
        }

        return $nodeId;
    }

    public function linkNodes($fromId, $toId)
    {
        $fromDirectory = $this->nodeStoreDirectory->directory($fromId);
        $link = $fromDirectory->link($toId);

        if (!$link->exists()) {
            
            $toDirectory = $this->nodeStoreDirectory->directory($toId);
            $link->create($toDirectory->path());
            
        }
    }
    
    public function separateNodes($fromId, $toId)
    {
        $fromDirectory = $this->nodeStoreDirectory->directory($fromId);
        $link = $fromDirectory->link($toId);

        if ($link->exists()) {
            
            $link->delete();
            
        }
    }
        
    public function isLinkedToNode($fromId, $toId)
    {
        $fromDirectory = $this->nodeStoreDirectory->directory($fromId);
        $link = $fromDirectory->directory($toId);

        return $link->exists();
    }
    
    public function getLinkedNodes($nodeId)
    {
        $nodeDirectory = $this->nodeStoreDirectory->directory($nodeId);

        $nodeIds = $nodeDirectory->names();

        return $nodeIds;
    }

    public function getValueNode(array $structure)
    {
        return $this->valueStore->getNode($structure);
    }
        
    public function getNodeValue($nodeId)
    {
        list($isFile, $content) = $this->nodeStore->getValue($nodeId);
        
        return new Value($isFile, $content);
    }
    
    public function getValue(array $structure)
    {
        return $this->valueStore->makeValue($structure);
    }
}
