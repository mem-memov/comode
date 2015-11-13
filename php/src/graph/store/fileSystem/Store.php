<?php
namespace Comode\graph\store\fileSystem;

use Comode\graph\store\IStore;
use Comode\graph\store\Value;
use Comode\graph\store\IValue;
use Comode\graph\store\exception\ValueNotFound;
use Comode\graph\store\exception\ValueMustBeLinkedToOneNode;

class Store implements IStore {

    private $node;
    private $value;

    public function __construct(
        INode $node, 
        IValue $value
    ) {
        $this->node = $node;
        $this->value = $value;
    }

    public function nodeExists($nodeId)
    {
        return $this->node->directory($nodeId)->exists();
    }
    
    public function createNode(IValue $value = null)
    {
        // read node by value
        if (!is_null($value)) {
            $nodeId = $this->value->getNode($value);
            if (!is_null($nodeId)) {
                return $nodeId;
            }
        }

        // create new node
        $nodeId = $this->node->create();

        if (!is_null($value)) {
            $valueHash = $this->value->create($value);
            $this->node->bindValue($nodeId, $this->value->directory($valueHash));
            $this->value->bindNode($valueHash, $this->node->directory($nodeId));
        }

        return $nodeId;
    }

    public function linkNodes($fromId, $toId)
    {
        $fromDirectory = $this->nodeDirectory->directory($fromId);
        $link = $fromDirectory->link($toId);

        if (!$link->exists()) {
            
            $toDirectory = $this->nodeDirectory->directory($toId);
            $link->create($toDirectory->path());
            
        }
    }
    
    public function separateNodes($fromId, $toId)
    {
        $fromDirectory = $this->nodeDirectory->directory($fromId);
        $link = $fromDirectory->link($toId);

        if ($link->exists()) {
            
            $link->delete();
            
        }
    }
        
    public function isLinkedToNode($fromId, $toId)
    {
        $fromDirectory = $this->nodeDirectory->directory($fromId);
        $link = $fromDirectory->directory($toId);

        return $link->exists();
    }
    
    public function getLinkedNodes($nodeId)
    {
        $nodeDirectory = $this->nodeDirectory->directory($nodeId);

        $nodeIds = $nodeDirectory->names();

        return $nodeIds;
    }

    public function getValueNode(IValue $value)
    {
        return $this->value->getNode($value);
    }
        
    public function getNodeValue($nodeId)
    {
        return $this->node->getValue($nodeId);
    }
    
    public function getValue($isFile, $content)
    {
        return $this->value->makeStoreValue($isFile, $content);
    }
}
