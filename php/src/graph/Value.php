<?php
namespace Comode\graph;

use Comode\graph\store\IStore;

class Value implements IValue
{
    private $store;
    private $nodeFactory;
    private $storeValue;
    
    public function __construct(IStore $store, INodeFactory $nodeFactory, $isFile, $content)
    {
        $this->store = $store;
        $this->nodeFactory = $nodeFactory;
        
        $this->storeValue = $this->store->getValue($isFile, $content);
    }
    
    public function getNode()
    {
        $id = $this->store->getValueNode($this->storeValue);
        
        if (is_null($id)) {
            return null;
        }
        
        $node = $this->nodeFactory->readNode($id);
        return $node;
    }
    
    public function isFile()
    {
        return $this->storeValue->isFile();;
    }
    
    public function getContent()
    {
        return $this->storeValue->getContent();
    }
}