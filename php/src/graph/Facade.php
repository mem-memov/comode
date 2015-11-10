<?php
namespace Comode\graph;

class Facade extends Factory
{
    public function __construct(array $config)
    {
        $configuration = new Configuration($config);
        
        $store = $configuration->getStore();
        
        $nodeFactory = new NodeFactory($store);
        $valueFactory = new ValueFactory($store);
        $nodeFactory->setValueFactory($valueFactory);
        $valueFactory->setNodeFactory($nodeFactory);
        
        parent::__construct($nodeFactory, $valueFactory);
    }
}