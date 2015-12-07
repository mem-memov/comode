<?php
namespace Comode\graph\store\fileSystem\value;

use Comode\graph\store\fileSystem\IWrapper as IFileSystem;

class File implements IFile
{
    private $fileSystem;

    public function __construct(
        IFileSystem $fileSystem
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