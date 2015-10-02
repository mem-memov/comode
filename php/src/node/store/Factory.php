<?php
namespace Comode\node\store;

class Factory
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }
    
    public function makeFileSystem()
    {
        return new FileSystem($this->config['path']);
    }

}