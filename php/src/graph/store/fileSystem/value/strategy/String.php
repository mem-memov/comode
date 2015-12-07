<?php
namespace Comode\graph\store\fileSystem\value\strategy;

use Comode\graph\store\fileSystem\directory\IDirectory;
use Comode\graph\store\fileSystem\value\IHash;
use Comode\graph\store\value\IString as IStoreValueString;

class String implements IValue
{
    private $valueRoot;
    private $nodeIndex;
    private $valueHash;
    private $nodeIdExtractor;
    private $value;
    
    public function __construct(
        IDirectory $valueRoot,
        IDirectory $nodeIndex,
        IHash $valueHash,
        INodeIdExtractor $nodeIdExtractor,
        IStoreValueString $value
    ) {
        $this->valueRoot = $valueRoot;
        $this->nodeIndex = $nodeIndex;
        $this->hash = $valueHash;
        $this->nodeIdExtractor = $nodeIdExtractor;
        $this->value = $value;
    }

    public function create()
    {
        $string = $value->getContent();
        
        $valueHash = $this->hash->string($string);
        
        $valueDirectory = $this->valueRoot->directory($valueHash);
        
        $valueDirectory->create();
        
        $valueDirectory->file($valueHash)->write($string);
        
        return $valueHash;
    }
    
    public function getNode(IHash $hash, IDirectory $nodeIndex) 
    {
        $string = $value->getContent();
        $valueHash = $this->hash->string($string);

        $nodeIds = $this->nodeIndex->directory($valueHash)->names();

        $nodeId = $this->nodeIdExtractor->extractId($nodeIds);
        
        return $nodeId;
    }
    
}