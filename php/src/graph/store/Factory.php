<?php
namespace Comode\graph\store;

use Comode\graph\value\IFactory as IValueFactory;

class Factory
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
        $this->valueFactory = $valueFactory;
    }
    
    public function makeFileSystem()
    {
        return new FileSystem($this->config['path']);
    }
}
