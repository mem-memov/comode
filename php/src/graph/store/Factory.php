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
        $id = new fileSystem\Id($path . '/lastId', $wrapper);
        $hash = new fileSystem\Hash();
        $file = new fileSystem\File($wrapper);
        
        $nodeStore = new fileSystem\NodeStore($nodeDirectory, $nodeToValueDirectory, $id);
        $valueStore = new fileSystem\ValueStore($valueDirectory, $valueToNodeDirectory, $hash, $file);
        
        return new fileSystem\Store($nodeStore, $valueStore);
    }
}
