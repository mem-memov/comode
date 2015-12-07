<?php
namespace Comode\graph;

use Comode\graph\store\IStore;

class NodeFactory implements INodeFactory
{
    private $store;
    private $valueFactory;
    
    public function __construct(IStore $store)
    {
        $this->store = $store;
    }
    
    public function setValueFactory(IValueFactory $valueFactory)
    {
        $this->valueFactory = $valueFactory;
    }

    public function createNode(array $structure = [])
    {
        return new Node($this->store, $this->valueFactory, $this, null, $structure);
    }

    public function readNode($nodeId)
    {
        return new Node($this->store, $this->valueFactory, $this, $nodeId);
    }
}