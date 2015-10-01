<?php
namespace Comode\node\store\fileSystem\os;

class Factory implements IFactory
{
    private $instances = [];
    
    public function __construct()
    {
        
    }

    public function makeWindows()
    {
        if (!$this->instances[__FUNCTION__]) {
            $this->instances[__FUNCTION__] = new Windows();
        }
        
        return $this->instances[__FUNCTION__];
    }

    public function makeLinux()
    {
        if (!$this->instances[__FUNCTION__]) {
            $this->instances[__FUNCTION__] = new Linux();
        }
        
        return $this->instances[__FUNCTION__];
    }
}