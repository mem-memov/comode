<?php
namespace Comode\graph\store\fileSystem;

class Factory implements IFactory
{
    private $fileSystem;
    
    private $node;
    private $value;
    private $valueToNodeIndex;
    private $nodeToValueIndex;
    
    public function __construct(
        IWrapper $fileSystem
    ) {
        $this->fileSystem = $fileSystem;
        
        $this->graphPath = $this->path . '/node';
        $this->valuePath = $this->path . '/value';
        $this->valueToNodeIndexPath = $this->path . '/value_to_node';
        $this->nodeToValueIndexPath = $this->path . '/node_to_value';
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
    
    public function initialize()
    {
        $this->root = new Directory($this->path);
        $this->node = $this->root->makeDirectory('node');
        $this->value = $this->root->makeDirectory('value');
        $this->valueToNodeIndex = $this->root->makeDirectory('value_to_node');
        $this->nodeToValueIndex = $this->root->makeDirectory('node_to_value');
    }
    
    public function valueToNodeIndex($valueHash)
    {
        $path = $this->valueToNodeIndexPath . '/' . $valueHash;
        
        $directory = new Directory($this->valueToNodeIndexPath);
        
        if (!$this->fileSystem->fileExists($valueToNodeIndexPath)) {
            $this->fileSystem->makeDirectory($valueToNodeIndexPath);
        }
        
        return $valueToNodeIndexPath;
    }
    
    public function nodeToValueIndex($nodeId, $mustCreate)
    {
        $nodeToValueIndexPath = $this->nodeToValueIndexPath . '/' . $nodeId;
        
        if (!$this->fileSystem->fileExists($nodeToValueIndexPath)) {
            $this->fileSystem->makeDirectory($nodeToValueIndexPath);
        }
        
        return $nodeToValueIndexPath;
    }
    
    public function value($valueHash)
    {
        $valuePath = $this->valuePath . '/' . $valueHash;
        
        if (!$this->fileSystem->fileExists($valuePath)) {
            $this->fileSystem->makeDirectory($valuePath);
        }
        
        return $valuePath;
    }
    
    private function node($nodeId, $mustCreate)
    {
        $nodePath = $this->graphPath . '/' . $nodeId;
        
        if ($mustCreate && !$this->fileSystem->fileExists($nodePath)) {
            $this->fileSystem->makeDirectory($nodePath);
        }
        
        return $nodePath;
    }
}