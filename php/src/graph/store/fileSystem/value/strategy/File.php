<?php
namespace Comode\graph\store\fileSystem\value\strategy;

use Comode\graph\store\fileSystem\directory\IDirectory;
use Comode\graph\store\fileSystem\value\IHash;
use Comode\graph\store\fileSystem\value\IFile;
use Comode\graph\store\value\IString as IStoreValueFile;

class File implements IValue
{
    private $valueRoot;
    private $nodeIndex;
    private $valueHash;
    private $file;
    private $nodeIdExtractor;
    private $value;
    
    public function __construct(
        IDirectory $valueRoot,
        IDirectory $nodeIndex,
        IHash $valueHash,
        IFile $file,
        INodeIdExtractor $nodeIdExtractor,
        IStoreValueFile $value
    ) {
        $this->valueRoot = $valueRoot;
        $this->nodeIndex = $nodeIndex;
        $this->hash = $valueHash;
        $this->file = $file;
        $this->nodeIdExtractor = $nodeIdExtractor;
        $this->value = $value;
    }
    
    public function create(IHash $hash, IDirectory $valueRoot)
    {
        $originPath = $value->getPath();
        
        $valueHash = $this->hash->file($originPath);
        
        $valueDirectory = $this->valueRoot->directory($valueHash);
        
        $valueDirectory->create();

        $this->file->copy($originPath, $valueDirectory->path());
        
        return $valueHash;
    }
    
    public function getNode(IHash $hash, IDirectory $nodeIndex)
    {
        $path = $value->getPath();
        $valueHash = $this->hash->file($path);

        $nodeIds = $this->nodeIndex->directory($valueHash)->names();

        $nodeId = $this->nodeIdExtractor->extractId($nodeIds);
        
        return $nodeId;
    }
    
}