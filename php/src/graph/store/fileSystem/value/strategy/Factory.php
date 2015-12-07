<?php
namespace Comode\graph\store\fileSystem\value\strategy;

use Comode\graph\store\value\IString;
use Comode\graph\store\value\IFile;

class Factory implements IFactory
{
    private $valueRoot;
    private $nodeIndex;
    private $valueHash;
    private $file;
    
    public function __construct(
        IDirectory $valueRoot,
        IDirectory $nodeIndex,
        IHash $valueHash,
        IFile $file
    ) {
        $this->valueRoot = $valueRoot;
        $this->nodeIndex = $nodeIndex;
        $this->hash = $valueHash;
        $this->file = $file;
    }
    
    public function makeString(IString $stringValue)
    {
        return new String($stringValue);
    }
    
    public function makeFile(IFile $fileValue)
    {
        return new File($fileValue);
    }
}