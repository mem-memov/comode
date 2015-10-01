<?php
namespace Comode\node;

class Factory implements IFactory
{
    private $config;
    private $instances = [];

    public function __construct($config)
    {
        $this->config = $config;
    }
    
    public function makeNode($id = null)
    {
        $storeFactory = $this->makeStoreFactory();
        $store = $storeFactory->makeStore();
        return new Node($store, $id);
    }
    
    /**
     * 
     * @return \Comode\node\store\IFactory
     */
    private function makeStoreFactory()
    {
        if (!isset($this->instances[__FUNCTION__])) {
            $this->instances[__FUNCTION__] = new store\Factory($this->config['store']);
        }

        return $this->instances[__FUNCTION__];
    }
}