<?php
namespace Comode\graph\store\fileSystem\directory;

use Comode\graph\store\fileSystem\IWrapper as IFileSystem;
use Comode\graph\store\fileSystem\IFactory;

class Value implements IValue
{
    private $fileSystem;

    public function __construct(
        IWrapper $fileSystem
    ) {
        $this->fileSystem = $fileSystem;
    }
    
    public function copy($originFile, $targetDirectory)
    {
        $fileName = $this->fileSystem->name($originFile);
        
        $targetFile = $targetDirectory . '/' . $fileName;
        
        $this->fileSystem->copy($originFile, $targetFile);
    }
    
}