<?php
namespace Comode\graph;

class Facade extends Factory
{
    public function __construct(array $config)
    {
        $storeFactory = new store\Factory();
        $configuration = new Configuration($storeFactory, $config);
        
        $store = $configuration->getStore();
        
        $nodeFactory = new NodeFactory($store);
        $valueFactory = new ValueFactory($store);
        $nodeFactory->setValueFactory($valueFactory);
        $valueFactory->setNodeFactory($nodeFactory);
        
        parent::__construct($nodeFactory, $valueFactory);
    }
}