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
        $directoryFactory = new fileSystem\directory\Factory();
        $root = $directoryFactory->make($path);
        
        $nodeDirectory = $root->get('node')->create();
        $nodeToValueDirectory = $root->get('node_to_value')->create();
        $valueDirectory = $root->get('value')->create();
        $valueToNodeDirectory = $root->get('value_to_node')->create();

        $wrapper = new fileSystem\Wrapper();
        $id = new fileSystem\node\Id($path . '/lastId', $wrapper);
        $hash = new fileSystem\value\Hash();
        $file = new fileSystem\value\File($wrapper);
        $startegyFactory = new fileSystem\value\strategy\Factory($valueDirectory, $valueToNodeDirectory, $hash, $file);
        $valueFactory = new value\Factory();
        
        
        $nodeStore = new fileSystem\node\Store($nodeDirectory, $nodeToValueDirectory, $id, $valueFactory);
        $valueStore = new fileSystem\value\Store($startegyFactory, $valueFactory);
        
        return new fileSystem\Store($nodeStore, $valueStore);
    }
}
