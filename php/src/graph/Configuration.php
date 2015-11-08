<?php
namespace Comode\graph;

class Configuration implements IConfiguration
{
    private $options;
    private $storeFactory;
    private $store;
    private $nodeFactory;
    private $valueFactory;
    
    public function __construct(array $options)
    {
        if (
            !isset($options['store']) 
            || !isset($options['store']['type'])
        ) {
            throw new exception\OptionMissing('Store type missing.');
        }
        
        $this->options = $options;
    }
    
    public function makeNodeFactory()
    {
        $this->bindNodeAndValueFactories();
        
        return $this->nodeFactory;
    }

    public function makeValueFactory()
    {
        $this->bindNodeAndValueFactories();
        
        return $this->valueFactory;
    }
    
    private function bindNodeAndValueFactories()
    {
        if (is_null($this->nodeFactory) && is_null($this->valueFactory)) {
            $this->nodeFactory = new NodeFactory($this->makeStore());
            $this->valueFactory = new ValueFactory($this->makeStore());
            $this->nodeFactory->setValueFactory($this->valueFactory);
            $this->valueFactory->setNodeFactory($this->nodeFactory);
        }
    }
    
    private function makeStore()
    {
        if (is_null($this->store)) {
            $storeFactory = $this->makeStoreFactory();
            
            switch ($this->options['store']['type']) {
                case 'fileSystem':
                    $this->store = $storeFactory->makeFileSystem($this->options['store']);
                    break;
                default:
                    throw new exception\OptionUnknown('Unknown store type: ' . $this->options['store']['type']);
                    break;
            }
        }
        
        return $this->store;
    }
    
    private function makeStoreFactory()
    {
        if (is_null($this->storeFactory)) {
            $this->storeFactory = new store\Factory();
        }
        
        return $this->storeFactory;
    }
}