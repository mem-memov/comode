<?php
namespace Comode\graph;

class Facade extends Factory
{
    public function __construct(array $config)
    {
        $storeFactory = new store\Factory();
        $configuration = new Configuration($storeFactory, $config);
        
        $store = $configuration->makeStore();

        parent::__construct($store);
    }
}