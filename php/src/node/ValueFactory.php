<?php
namespace Comode\node;

use Comode\node\store\IStore;

class ValueFactory implements IValueFactory
{
    private $store;
    private $nodeFactory;
    
    public function __construct(IStore $store, INodeFactory $nodeFactory)
    {
        $this->store = $store;
        $this->nodeFactory = $nodeFactory;
    }
    
    public function setNodeFactory(INodeFactory $nodeFactory)
    {
        $nodeFactory = $this->nodeFactory;
    }
    
    public function makeValue($isFile, $content)
    {
        return new Value($this->store, $this->nodeFactory, $isFile, $content);
    }
}