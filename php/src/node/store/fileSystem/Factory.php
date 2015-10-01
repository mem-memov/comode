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
        if (!$this->instances[__FUNCTION__]) {
            $this->instances[__FUNCTION__] = new FileSystem($this->makeOs());
            
        }
        
        return $this->instances[__FUNCTION__];
    }

    private function makeOs()
    {
        if (!$this->instances[__FUNCTION__]) {
            switch ($this->config['os']) {
                case 'Windows':
                    $this->instances[__FUNCTION__] = $this->makeWindows();
                    break;
                case 'Linux':
                    $this->instances[__FUNCTION__] = $this->makeLinux();
                    break;
                default:
                    throw new UnknownOsType();
                    break;
            }
            
        }
        
        return $this->instances[__FUNCTION__];
    }
}