<?php
namespace Comode\graph\store\fileSystem;

class Store implements IId
{
    private $fileSystem;
    
    public function __construct($path, IWrapper $fileSystem)
    {
        $this->path = $path;
        $this->fileSystem = $fileSystem;
    }
    
    public function next()
    {
        if (!$this->fileSystem->fileExists($this->path)) {
            $this->fileSystem->writeFile($this->path, 0);
        }

        $lastId = $this->fileSystem->readFile($this->path);

        $nextId = $lastId + 1;

        $this->fileSystem->writeFile($this->path, $nextId);

        return (int)$nextId;
    }
}