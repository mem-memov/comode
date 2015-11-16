<?php
namespace Comode\graph\store\fileSystem\directory;

use Comode\graph\store\fileSystem\IWrapper as IFileSystem;

class Link implements ILink
{
    private $path;
    private $fileSystem;
    private $factory;
 
    public function __construct(
        $path,
        IFileSystem $fileSystem,
        IFactory $factory
    ) {
        $this->path = $path;
        $this->fileSystem = $fileSystem;
        $this->factory = $factory;
    }
    
    public function exists()
    {
        return $this->fileSystem->exists($this->path);
    }
    
    public function create($path)
    {
        $this->fileSystem->makeLink($path, $this->path);
    }
    
    public function delete()
    {
        $this->fileSystem->deleteLink($this->path);
    }
    
    public function directory()
    {
        $path = $this->fileSystem->readLink($this->path);
        
        return $this->factory->directory($path);
    }
}