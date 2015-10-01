<?php
namespace Comode\node\store\fileSystem;

class Factory implements IFactory
{
    private $config;
    private $instances = [];
    
    public function __construct($config)
    {
        $this->config = $config;
    }
    
    public function makeFileSystem()
    {
        if (!isset($this->instances[__FUNCTION__])) {
            $this->instances[__FUNCTION__] = new FileSystem($this->config['path']);
            
        }
        
        return $this->instances[__FUNCTION__];
    }
}