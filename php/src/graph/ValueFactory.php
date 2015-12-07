<?php
namespace Comode\graph;

use Comode\graph\store\IStore;

class ValueFactory implements IValueFactory
{
    private $store;
    private $nodeFactory;
    
    public function __construct(IStore $store)
    {
        $this->store = $store;
    }
    
    public function setNodeFactory(INodeFactory $nodeFactory)
    {
        $this->nodeFactory = $nodeFactory;
    }
    
    public function makeValue(array $structure)
    {
        return new Value($this->store, $this->nodeFactory, $structure);
    }

}