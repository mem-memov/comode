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
        $path = $options['path'];
        $wrapper = new fileSystem\Wrapper();
        $id = new Id($path, $wrapper);
        return new fileSystem\Store($path, $wrapper);
    }
}
