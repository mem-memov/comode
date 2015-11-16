<?php
namespace Comode\graph\store\fileSystem;

use Comode\graph\store\IValue as IStoreValue;
use Comode\graph\store\Value as StoreValue;

class ValueStore implements IValueStore
{
    private $values;
    private $nodes;
    private $valueHash;
    private $file;
 
    public function __construct(
        IDirectory $values,
        IDirectory $nodes,
        IHash $valueHash,
        IFile $file
    ) {
        $this->values = $values;
        $this->nodes = $nodes;
        $this->hash = $valueHash;
        $this->file = $file;
    }
    
    private function create(IStoreValue $value)
    {
        if ($value->isFile()) {
            
            $originPath = $value->getContent();
            
            $valueHash = $this->hash->file($originPath);
            
            $valueDirectory = $this->values->directory($valueHash);
            
            $valueDirectory->create();

            $this->file->copy($originPath, $valueDirectory->path());


        } else {
            
            $string = $value->getContent();
            
            $valueHash = $this->hash->string($string);
            
            $valueDirectory = $this->values->directory($valueHash);
            
            $valueDirectory->create();
            
            $valueDirectory->file($valueHash)->write($string);

        }

        return $valueHash;
    }
    
    public function bindNode($valueHash, IDirectory $nodeDirectory)
    {
        $this->nodes
            ->directory($valueHash)
            ->link($nodeDirectory->name())
            ->create($nodeDirectory->path());
    }
    
    public function getNode(IStoreValue $value)
    {
        if ($value->isFile()) {
            $path = $value->getContent();
            $valueHash = $this->hash->file($path);
        } else {
            $string = $value->getContent();
            $valueHash = $this->hash->string($string);
        }

        $nodeIds = $this->nodes->directory($valueHash)->names();

        $nodeCount = count($nodeIds);

        if ($nodeCount == 0) {
            $nodeId = null;
        } elseif ($nodeCount == 1) {
            $nodeId = (int)$nodeIds[0];
        } else {
            throw new ValueMustBeLinkedToOneNode('Value with content ' . $value->getContent() . ' has too many nodes: ' . $nodeCount);
        }
        
        return $nodeId;
    }
    
    public function makeStoreValue($isFile, $content)
    {
        if (!$isFile) {
            $value = new StoreValue(false, $content);
        } else {
            $valueHash = $this->hash->hashFile($content);
            $valueDirectory = $this->valueDirectory->directory($valueHash);
            $valuePaths = $valueDirectory->paths();
            
            $valuePath = $valuePaths[0];
            $value = new StoreValue(true, $valuePath);
        }
        
        return $value;
    }
}