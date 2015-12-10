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
        
        $path = $options['path'];
        $directoryFactory = new fileSystem\directory\Factory($wrapper);
        $root = $directoryFactory->directory($path);
        
        $nodeDirectory = $root->directory('node');
        if (!$nodeDirectory->exists()) {
            $nodeDirectory->create();
        }
        $nodeToValueDirectory = $root->directory('node_to_value');
        if (!$nodeToValueDirectory->exists()) {
            $nodeToValueDirectory->create();
        }
        $valueDirectory = $root->directory('value');
        if (!$valueDirectory->exists()) {
            $valueDirectory->create();
        }
        $valueToNodeDirectory = $root->directory('value_to_node');
        if (!$valueToNodeDirectory->exists()) {
            $valueToNodeDirectory->create();
        }

        $id = new fileSystem\node\Id($path . '/lastId', $wrapper);

        $nodeStore = new fileSystem\node\Store($nodeDirectory, $nodeToValueDirectory, $id);
        $valueStore = new fileSystem\value\Store($valueDirectory, $valueToNodeDirectory);
        
        return new fileSystem\Store($nodeStore, $valueStore);
    }
}
