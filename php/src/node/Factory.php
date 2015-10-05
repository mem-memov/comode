<?php
namespace Comode\node;

class Factory implements IFactory
{
    private $config;
    private $storeFactory;
    private $valueFactory;
    private $store;

    public function __construct($config)
    {
        $this->config = $config;
    }
    
    public function makeNode($id = null, $value = null)
    {
        $store = $this->makeStore();
        
        if (!is_null($value)) {
            $value = $this->makeValue($value);
        }
        
        return new Node($store, $id, $value);
    }
    
    public function getChildNodes(INode $node)
    {
        $store = $this->makeStore();
        
        $childIds = $store->getChildNodes($node->getId());
        
        $childNodes = [];
        
        foreach ($childIds as $childId) {
            $childNode = $this->makeNode($childId);
            array_push($childNodes, $childNode);
        }
        
        return $childNodes;
    }
    
    public function getNodesByValue($value)
    {
        $value = $this->makeValue($value);
        $ids = $this->store->getNodesByValue(new store\Value(file_exists($value), $value));
        
        $nodes = [];
        
        foreach ($ids as $id) {
            $node = $this->makeNode($id);
            array_push($nodes, $node);
        }
        
        return $nodes;
    }
    
    private function makeValue($value)
    {
        $valueFactory = $this->makeValueFactory();
        
        if (file_exists($value)) {
            return $valueFactory->makeFile($value);
        } else {
            return $valueFactory->makeString($value);
        }
    }
    
    private function makeStore()
    {
        $storeFactory = $this->makeStoreFactory();
        
        if (!isset($this->store)) {
            switch ($this->config['store']['type']) {
                case 'fileSystem':
                    $this->store = $storeFactory->makeFileSystem();
                    break;
                default:
                    throw new UnknownStoreType();
                    break;
            }
        }
        
        return $this->store;
    }
    
    private function makeStoreFactory()
    {
        if (!isset($this->storeFactory)) {
            $this->storeFactory = new store\Factory($this->config['store']);
        }

        return $this->storeFactory;
    }
    
    private function makeValueFactory()
    {
        if (!isset($this->valueFactory)) {
            $this->valueFactory = new value\Factory();
        }

        return $this->valueFactory;
    }
}
