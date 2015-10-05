<?php
namespace Comode\node\store;

use Comode\node\value\IFactory as IValueFactory;

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
