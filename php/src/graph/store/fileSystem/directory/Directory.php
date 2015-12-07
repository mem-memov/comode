<?php
namespace Comode\graph\store\fileSystem\directory;

use Comode\graph\store\fileSystem\IWrapper as IFileSystem;

class Directory implements IDirectory
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
    
    public function exists()
    {
        return $this->fileSystem->exists($this->path);
    }
    
    public function create()
    {
        $this->fileSystem->makeDirectory($this->path);
    }
    
    public function paths()
    {
        return $this->fileSystem->readDirectory($this->path);
    }

    public function names()
    {
        $paths = $this->fileSystem->readDirectory($this->path);
        
        $names = [];
        
        foreach ($paths as $path) {
            $name = $this->fileSystem->name($path);
            array_push($names, $name);
        }
        
        return $names;
    }
    
    public function links()
    {
        $paths = $this->fileSystem->readDirectory($this->path);
        
        $links = [];
        
        foreach ($paths as $path) {
            $link = $this->factory->link($path);
            array_push($links, $link);
        }
        
        return $links;
    }
    
    public function files()
    {
        $paths = $this->fileSystem->readDirectory($this->path);
        
        $files = [];
        
        foreach ($paths as $path) {
            $file = $this->factory->file($path);
            array_push($files, $file);
        }
        
        return $files;
    }

    public function directory($name)
    {
        return $this->factory->directory($this->path . '/' . $name);
    }
    
    public function link($name)
    {
        return $this->factory->link($this->path . '/' . $name);
    }
    
    public function file($name)
    {
        return $this->factory->file($this->path . '/' . $name);
    }
}