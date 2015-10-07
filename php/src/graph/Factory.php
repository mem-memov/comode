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
    
    public function makeNode($id = null, $isFile = null, $content = null)
    {
        return $this->nodeFactory->makeNode($id, $isFile, $content);
    }

    public function makeValue($isFile, $content)
    {
        return $this->valueFactory->makeValue($isFile, $content);
    }

}
