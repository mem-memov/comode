<?php
namespace Comode\graph;

use Comode\graph\store\IStore;

class Value implements IValue
{
    private $store;
    private $nodeFactory;
    private $storeValue;
    
    public function __construct(IStore $store, INodeFactory $nodeFactory, array $structure)
    {
        $this->store = $store;
        $this->nodeFactory = $nodeFactory;
        
        $this->structure = $structure;
    }
    
    public function getNode()
    {
        $id = $this->store->getValueNode($this->structure);
        
        if (is_null($id)) {
            return null;
        }
        
        $node = $this->nodeFactory->readNode($id);
        return $node;
    }

    public function getStructure()
    {
        return $this->structure;
    }
}