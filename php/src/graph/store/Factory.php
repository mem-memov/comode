<?php
namespace Comode\graph\store;

use Comode\graph\value\IFactory as IValueFactory;

class Factory implements IFactory
{
    public function __construct()
    {
    }
    
    public function makeFileSystem(array $options)
    {
        $wrapper = new fileSystem\Wrapper();
        return new fileSystem\Store($options['path'], $wrapper);
    }
}
