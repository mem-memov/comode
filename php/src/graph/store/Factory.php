<?php
namespace Comode\graph\store;

use Comode\graph\value\IFactory as IValueFactory;

class Factory
{
    public function __construct()
    {
    }
    
    public function makeFileSystem(array $options)
    {
        return new FileSystem($options['path']);
    }
}
