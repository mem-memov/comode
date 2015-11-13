<?php
namespace Comode\graph\store\fileSystem\directory;

use Comode\graph\store\fileSystem\IWrapper as IFileSystem;
use Comode\graph\store\fileSystem\IFactory;

class File implements IFile
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
    
    public function path()
    {
        return $this->path;
    }
    
    public function name()
    {
        return $this->fileSystem->name($this->path);
    }
    
    public function read()
    {
        return $this->fileSystem->readFile($this->path);
    }
}