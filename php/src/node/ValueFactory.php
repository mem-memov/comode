<?php
namespace Comode\node;

use Comode\node\store\IStore;

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
        $nodeFactory = $this->nodeFactory;
    }
    
    public function makeValue($isFile, $content)
    {
        
    }
}