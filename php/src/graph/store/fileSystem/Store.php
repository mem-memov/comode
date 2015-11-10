<?php
namespace Comode\graph\store\fileSystem;

use Comode\graph\store\IStore;
use Comode\graph\store\Value;
use Comode\graph\store\IValue;
use Comode\graph\store\exception\ValueNotFound;
use Comode\graph\store\exception\ValueMustBeLinkedToOneNode;

class Store implements IStore {

    private $path;
    private $fileSystem;
    
    private $graphPath;
    private $valuePath;
    private $valueToNodeIndexPath;
    private $nodeToValueIndexPath;
    private $idFile = 'lastId';

    public function __construct($path, IWrapper $fileSystem)
    {
        $this->path = $path;
        $this->fileSystem = $fileSystem;

        if (!$this->fileSystem->fileExists($this->path)) {
            $this->fileSystem->makeDirectory($this->path);
        }
        
        $this->graphPath = $this->path . '/node';
        
        if (!$this->fileSystem->fileExists($this->graphPath)) {
            $this->fileSystem->makeDirectory($this->graphPath);
        }
        
        $this->valuePath = $this->path . '/value';
        
        if (!$this->fileSystem->fileExists($this->valuePath)) {
            $this->fileSystem->makeDirectory($this->valuePath);
        }
        
        $this->valueToNodeIndexPath = $this->path . '/value_to_node';
        
        if (!$this->fileSystem->fileExists($this->valueToNodeIndexPath)) {
            $this->fileSystem->makeDirectory($this->valueToNodeIndexPath);
        }
        
        $this->nodeToValueIndexPath = $this->path . '/node_to_value';
        
        if (!$this->fileSystem->fileExists($this->nodeToValueIndexPath)) {
            $this->fileSystem->makeDirectory($this->nodeToValueIndexPath);
        }
    }

    public function nodeExists($nodeId)
    {
        return $this->fileSystem->fileExists($this->buildNodePath($nodeId));
    }
    
    public function createNode(IValue $value = null)
    {
        if (!is_null($value)) {
            $nodeId = $this->getValueNode($value);
            if (!is_null($nodeId)) {
                return $nodeId;
            }
        }

        $nodeId = $this->nextId();
       
        $nodePath = $this->buildNodePath($nodeId);
        
        $this->fileSystem->makeDirectory($nodePath);
            
        if (!is_null($value)) {
            list($valueHash, $valuePath) = $this->createValue($value);
            $this->bindValueToNode($nodeId, $nodePath, $valueHash, $valuePath);
        }

        return $nodeId;
    }

    public function linkNodes($originId, $targetId)
    {
        $originPath = $this->graphPath . '/' . $originId . '/' . $targetId;

        if ($this->fileSystem->fileExists($originPath)) {
            return;
        }

        $targetPath = $this->graphPath . '/' . $targetId;
        $this->fileSystem->makeLink($targetPath, $originPath);
    }
    
    public function separateNodes($originId, $targetId)
    {
        $originPath = $this->graphPath . '/' . $originId . '/' . $targetId;
        
        if (!$this->fileSystem->fileExists($originPath)) {
            return;
        }
        
        $this->fileSystem->deleteLink($originPath);
    }
        
    public function isLinkedToNode($originId, $targetId)
    {
        $originPath = $this->buildNodePath($originId);
        
        $linkPath = $originPath . '/' . $targetId;
        
        return $this->fileSystem->fileExists($linkPath);
    }
    
    public function getLinkedNodes($nodeId)
    {
        $path = $this->buildNodePath($nodeId);
        $offset = strlen($path) + 1;
            
        $linkedPaths = glob($path . '/*');

        $linkedIds = [];
        foreach ($linkedPaths as $linkedPath) {
            $linkedId = (int)substr($linkedPath, $offset);
            array_push($linkedIds, $linkedId);
        }
            
        return $linkedIds;
    }

    public function getValueNode(IValue $value)
    {
        if ($value->isFile()) {
            $originPath = $value->getContent();
            $valueHash = $this->hashFile($originPath);
        } else {
            $string = $value->getContent();
            $valueHash = $this->hashString($string);
        }
        
        $indexPath = $this->valueToNodeIndexPath . '/' . $valueHash;
        $offset = strlen($indexPath) + 1;
            
        $nodePaths = glob($indexPath . '/*');

        $nodeCount = count($nodePaths);

        if ($nodeCount == 0) {
            $nodeId = null;
        } elseif ($nodeCount == 1) {
            $nodeId = (int)substr($nodePaths[0], $offset);
        } else {
            throw new ValueMustBeLinkedToOneNode('Value with content ' . $value->getContent() . ' has too many nodes: ' . $nodeCount);
        }
        
        return $nodeId;
    }
        
    public function getNodeValue($nodeId)
    {
        $indexPath = $this->nodeToValueIndexPath . '/' . $nodeId;
        
        $paths = glob($indexPath . '/*');

        if (empty($paths)) {
            throw new ValueNotFound();
        }

        $link = $paths[0];

        $valueDirectory = readlink($link);

        $valueHash = basename($valueDirectory);

        $valuePaths = glob($valueDirectory . '/*');

        $valuePath = $valuePaths[0];

        $fileName = basename($valuePath);

        if ($fileName == $this->nameStringValueFile($valueHash)) {
            $content = $this->fileSystem->readFile($valuePath);
            $value = new Value(false, $content);
        } else {
            $value = new Value(true, $valuePath);
        }

        return $value;
    }
    
    public function getValue($isFile, $content)
    {
        if (!$isFile) {
            $value = new Value(false, $content);
        } else {
            $valueHash = $this->hashFile($content);
            $valueDirectory = $this->createValueDirectory($valueHash);
            $valuePaths = glob($valueDirectory . '/*');
            
            $valuePath = $valuePaths[0];
            $value = new Value(true, $valuePath);
        }
        
        return $value;
    }

    // private methods

    private function nextId()
    {
        $lastIdPath = $this->path . '/' . $this->idFile;

        if (!$this->fileSystem->fileExists($lastIdPath)) {
            $this->fileSystem->writeFile($lastIdPath, 0);
        }

        $lastId = $this->fileSystem->readFile($lastIdPath);

        $nextId = $lastId + 1;

        $this->fileSystem->writeFile($lastIdPath, $nextId);

        return (int)$nextId;
    }
    
    private function createValue(IValue $value)
    {
        if ($value->isFile()) {
            
            $originPath = $value->getContent();

            $valueHash = $this->hashFile($originPath);
            
            $valuePath = $this->createValueDirectory($valueHash);

            $targetPath = $valuePath . '/' . basename($originPath);
            copy($originPath, $targetPath);

        } else {
            
            $string = $value->getContent();
            
            $valueHash = $this->hashString($string);
            
            $valuePath = $this->createValueDirectory($valueHash);
            
            $targetPath = $valuePath . '/' . $this->nameStringValueFile($valueHash);
            $this->fileSystem->writeFile($targetPath, $string);

        }

        return [$valueHash, $valuePath];
    }
    
    private function bindValueToNode($nodeId, $nodePath, $valueHash, $valuePath)
    {
        // value to node
        $valueToNodeIndexPath = $this->valueToNodeIndexPath . '/' . $valueHash;
        
        if (!$this->fileSystem->fileExists($valueToNodeIndexPath)) {
            $this->fileSystem->makeDirectory($valueToNodeIndexPath);
        }

        $this->fileSystem->makeLink($nodePath, $valueToNodeIndexPath . '/' . $nodeId);
         
        // node to value           
        $nodeToValueIndexPath = $this->nodeToValueIndexPath . '/' . $nodeId;
        
        if (!$this->fileSystem->fileExists($nodeToValueIndexPath)) {
            $this->fileSystem->makeDirectory($nodeToValueIndexPath);
        }
        
        $this->fileSystem->makeLink($valuePath, $nodeToValueIndexPath . '/' . $valueHash);
    }
    
    private function createValueDirectory($hash)
    {
        $valuePath = $this->valuePath . '/' . $hash;
        if (!$this->fileSystem->fileExists($valuePath)) {
            $this->fileSystem->makeDirectory($valuePath);
        }
        return $valuePath;
    }
    
    private function buildNodePath($nodeId)
    {
        return $this->graphPath . '/' . $nodeId;
    }
    
    private function nameStringValueFile($valueHash)
    {
        return $valueHash . '.txt';
    }

    private function hashFile($path)
    {
        return hash_file('md5', $path);
    }
    
    private function hashString($string)
    {
        return md5($string);
    }
}
