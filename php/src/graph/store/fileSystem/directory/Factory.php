<?php
namespace Comode\graph\store\fileSystem\directory;

use Comode\graph\store\fileSystem\IWrapper;

class Factory implements IFactory
{
    private $fileSystem;
    
    public function __construct(
        IWrapper $fileSystem
    ) {
        $this->fileSystem = $fileSystem;
    }
    
    public function directory($path)
    {
        return new Directory($path, $this->fileSystem, $this);
    }
    
    public function link($path)
    {
        return new Link($path, $this->fileSystem, $this);
    }
    
    public function file($path)
    {
        return new File($path, $this->fileSystem, $this);
    }
}