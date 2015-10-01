<?php
namespace Comode\node\store;

class Factory implements IFactory
{
    private $config;
    private $instances = [];
    
    public function __construct($config)
    {
        $this->config = $config;
    }
    
    public function makeStore()
    {
        if (!isset($this->instances[__FUNCTION__])) {
            switch ($this->config['type']) {
                case 'fileSystem':
                    $this->instances[__FUNCTION__] = $this->makeFileSystemStore();
                    break;
                default:
                    throw new UnknownStoreType();
                    break;
            }
            
        }
        
        return $this->instances[__FUNCTION__];
    }
    
    private function makeFileSystemStore()
    {
        if (!isset($this->instances[__FUNCTION__])) {
            $this->instances[__FUNCTION__] = $this->makeFileSystemFactory()->makeFileSystem();
        }

        return $this->instances[__FUNCTION__];
    }
    
    private function makeFileSystemFactory()
    {
        if (!isset($this->instances[__FUNCTION__])) {
            $this->instances[__FUNCTION__] = new fileSystem\Factory($this->config);
        }
        
        return $this->instances[__FUNCTION__];
    }
}