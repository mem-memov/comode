<?php
namespace Comode\graph\store\fileSystem\value;

use Comode\graph\store\fileSystem\directory\IDirectory;

class Store implements IStore
{
    private $valueRoot;
    private $nodeIndex;

    public function __construct(
        IDirectory $valueRoot,
        IDirectory $nodeIndex
    ) {
        $this->valueRoot = $valueRoot;
        $this->nodeIndex = $nodeIndex;
    }
    
    private function create($value)
    {
        $valueHash = md5($value);
        $valueDirectory = $this->valueRoot->directory($valueHash);
        $valueDirectory->create();
        $valueDirectory->file($valueHash)->write($string);
        
        return $valueHash;
    }
    
    public function bindNode($valueHash, IDirectory $nodeDirectory)
    {
        $this->nodeIndex
            ->directory($valueHash)
            ->link($nodeDirectory->name())
            ->create($nodeDirectory->path());
    }
    
    public function getNode($value)
    {
        $valueHash = md5($value);
        
        $nodeIds = $this->nodeIndex->directory($valueHash)->names();
        
        $nodeCount = count($nodeIds);

        if ($nodeCount == 0) {
            $nodeId = null;
        } elseif ($nodeCount == 1) {
            $nodeId = (int)$nodeIds[0];
        } else {
            throw new ValueMustBeLinkedToOneNode('Value with content ' . $json . ' has too many nodes: ' . $nodeCount);
        }
        
        return $nodeId;
    }
}