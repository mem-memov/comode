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

    public function createNode()
    {
        return new Node($this->store, $this->valueFactory, $this, null, null, null);
    }
    
    public function createFileNode($path)
    {
        return new Node($this->store, $this->valueFactory, $this, null, true, $path);
    }
    
    public function createStringNode($content)
    {
        return new Node($this->store, $this->valueFactory, $this, null, false, $content);
    }
    
    public function readNode($nodeId)
    {
        return new Node($this->store, $this->valueFactory, $this, $nodeId, null, null);
    }
}