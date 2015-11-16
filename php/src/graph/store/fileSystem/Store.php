<?php
namespace Comode\graph\store\fileSystem;

use Comode\graph\store\IStore;
use Comode\graph\store\Value;
use Comode\graph\store\IValue;
use Comode\graph\store\exception\ValueNotFound;
use Comode\graph\store\exception\ValueMustBeLinkedToOneNode;

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
    
    public function createNode(IValue $value = null)
    {
        // read node by value
        if (!is_null($value)) {
            $nodeId = $this->valueStore->getNode($value);
            if (!is_null($nodeId)) {
                return $nodeId;
            }
        }

        // create new node
        $nodeId = $this->nodeStore->create();

        if (!is_null($value)) {
            $valueHash = $this->valueStore->create($value);
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

    public function getValueNode(IValue $value)
    {
        return $this->valueStore->getNode($value);
    }
        
    public function getNodeValue($nodeId)
    {
        return $this->nodeStore->getValue($nodeId);
    }
    
    public function getValue($isFile, $content)
    {
        return $this->valueStore->makeStoreValue($isFile, $content);
    }
}
