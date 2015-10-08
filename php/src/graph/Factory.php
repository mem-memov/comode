<?php
namespace Comode\graph;

class Factory implements IFactory
{
    private $nodeFactory;
    private $valueFactory;

    public function __construct($config)
    {
        $storeFactory = new store\Factory($config['store']);
        
        switch ($config['store']['type']) {
            case 'fileSystem':
                $store = $storeFactory->makeFileSystem();
                break;
            default:
                throw new UnknownStoreType();
                break;
        }
        
        $this->nodeFactory = new NodeFactory($store);
        $this->valueFactory = new ValueFactory($store);
        $this->nodeFactory->setValueFactory($this->valueFactory);
        $this->valueFactory->setNodeFactory($this->nodeFactory);

    }

    public function createNode()
    {
        return $this->nodeFactory->createNode();
    }
    
    public function createFileNode($path)
    {
         return $this->nodeFactory->createFileNode($path);
    }
    
    public function createStringNode($content)
    {
         return $this->nodeFactory->createStringNode($content);
    }
    
    public function readNode($nodeId)
    {
         return $this->nodeFactory->readNode($nodeId);
    }

    public function makeStringValue($content)
    {
        return $this->valueFactory->makeStringValue($content);
    }
    
    public function makeFileValue($path)
    {
        return $this->valueFactory->makeFileValue($path);
    }

}
