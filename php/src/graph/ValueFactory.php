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
    
    public function makeStringValue($content)
    {
        return new Value($this->store, $this->nodeFactory, false, $content);
    }
    
    public function makeFileValue($path)
    {
        return new Value($this->store, $this->nodeFactory, true, $path);
    }
}