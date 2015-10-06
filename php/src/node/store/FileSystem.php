<?php
namespace Comode\node\store;

use Comode\node\value\IFactory as IValueFactory;

class FileSystem implements IStore {

    private $path;
    private $graphPath;
    private $valuePath;
    private $valueToNodeIndexPath;
    private $nodeToValueIndexPath;
    private $idFile = 'lastId';

    public function __construct($path)
    {
        $this->path = $path;
        $this->valueFactory = $valueFactory;
        
        if (!file_exists($this->path)) {
            mkdir($this->path, 0777, true);
        }
        
        $this->graphPath = $this->path . '/node';
        
        if (!file_exists($this->graphPath)) {
            mkdir($this->graphPath, 0777, true);
        }
        
        $this->valuePath = $this->path . '/value';
        
        if (!file_exists($this->valuePath)) {
            mkdir($this->valuePath, 0777, true);
        }
        
        $this->valueToNodeIndexPath = $this->path . '/value_to_node';
        
        if (!file_exists($this->valueToNodeIndexPath)) {
            mkdir($this->valueToNodeIndexPath, 0777, true);
        }
        
        $this->nodeToValueIndexPath = $this->path . '/node_to_value';
        
        if (!file_exists($this->nodeToValueIndexPath)) {
            mkdir($this->nodeToValueIndexPath, 0777, true);
        }
    }

    public function nodeExists($nodeId)
    {
        return file_exists($this->buildNodePath($nodeId));
    }
    
    public function createNode(IValue $value = null)
    {
        $nodeId = $this->nextId();
        
        $nodePath = $this->buildNodePath($nodeId);
        
        mkdir($nodePath, 0777, true);
        
        if (!is_null($value)) {
            list($valueHash, $valuePath) = $this->createValue($value);
            $this->bindValueToNode($nodeId, $nodePath, $valueHash, $valuePath);
        }
        
        return $nodeId;
    }

    public function linkNodes($originId, $targetId)
    {
        $originPath = $this->graphPath . '/' . $originId . '/' . $targetId;

        if (file_exists($originPath)) {
            return;
        }

        $targetPath = $this->graphPath . '/' . $targetId;
        symlink($targetPath, $originPath);
    }
        
    public function getChildNodes($parentId)
    {
        $path = $this->graphPath . '/' . $parentId;
        $offset = strlen($path) + 1;
            
        $childPaths = glob($path . '/*');

        $childIds = [];
        foreach ($childPaths as $childPath) {
            $childId = (int)substr($childPath, $offset);
            array_push($childIds, $childId);
        }
            
        return $childIds;
    }
        
    public function getNodesByValue(IValue $value)
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
            
        $nodeIds = [];
        foreach ($nodePaths as $nodePath) {
            $nodeId = (int)substr($nodePath, $offset);
            array_push($nodeIds, $nodeId);
        }
            
        return $nodeIds;
    }
        
    public function getValue($nodeId)
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
            $content = file_get_contents($valuePath);
            $value = new Value(false, $content);
        } else {
            $value = new Value(true, $valuePath);
        }

        return $value;
    }
    
    // private methods

    private function nextId()
    {
        $lastIdPath = $this->path . '/' . $this->idFile;

        if (!file_exists($lastIdPath)) {
            file_put_contents($lastIdPath, 0);
        }

        $lastId = file_get_contents($lastIdPath);

        $nextId = $lastId + 1;

        file_put_contents($lastIdPath, $nextId);

        return (int)$nextId;
    }
    
    private function createValue(IValue $value)
    {
        if ($value->isFile()) {
            
            $originPath = $value->getContent();
            
            $valueHash = $this->hashFile($originPath);
            
            $valuePath = $this->createValueDirectory($valueHash);

            $targetPath = $valuePath . basename($originPath);
            copy($originPath, $targetPath);

        } else {
            
            $string = $value->getContent();
            
            $valueHash = $this->hashString($string);
            
            $valuePath = $this->createValueDirectory($valueHash);
            
            $targetPath = $valuePath . '/' . $this->nameStringValueFile($valueHash);
            file_put_contents($targetPath, $string);

        }

        return [$valueHash, $valuePath];
    }
    
    private function bindValueToNode($nodeId, $nodePath, $valueHash, $valuePath)
    {
        // value to node
        $valueToNodeIndexPath = $this->valueToNodeIndexPath . '/' . $valueHash;
        
        if (!file_exists($valueToNodeIndexPath)) {
            mkdir($valueToNodeIndexPath, 0777, true);
        }
        
        symlink($nodePath, $valueToNodeIndexPath . '/' . $nodeId);
         
        // node to value           
        $nodeToValueIndexPath = $this->nodeToValueIndexPath . '/' . $nodeId;
        
        if (!file_exists($nodeToValueIndexPath)) {
            mkdir($nodeToValueIndexPath, 0777, true);
        }
        
        symlink($valuePath, $nodeToValueIndexPath . '/' . $valueHash);
    }
    
    private function createValueDirectory($hash)
    {
        $valuePath = $this->valuePath . '/' . $hash;
        if (!file_exists($valuePath)) {
            mkdir($valuePath, 0777, true);
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
