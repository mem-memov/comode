<?php
namespace Comode\graph\store;

use Comode\graph\value\IFactory as IValueFactory;

class FileSystem implements IStore {

    private $path;
    private $initialized;
    private $graphPath;
    private $valuePath;
    private $valueToNodeIndexPath;
    private $nodeToValueIndexPath;
    private $idFile = 'lastId';

    public function __construct($path)
    {
        $this->path = $path;
        $this->initialized = false;
    }

    public function nodeExists($nodeId)
    {
        $this->initialize();
        
        return file_exists($this->buildNodePath($nodeId));
    }
    
    public function createNode(IValue $value = null)
    {
        $this->initialize();
        
        if (!is_null($value)) {
            $nodeId = $this->getValueNode($value);
            if (!is_null($nodeId)) {
                return $nodeId;
            }
        }

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
        $this->initialize();
        
        $originPath = $this->graphPath . '/' . $originId . '/' . $targetId;

        if (file_exists($originPath)) {
            return;
        }

        $targetPath = $this->graphPath . '/' . $targetId;
        symlink($targetPath, $originPath);
    }
    
    public function separateNodes($originId, $targetId)
    {
        $this->initialize();
        
        $originPath = $this->graphPath . '/' . $originId . '/' . $targetId;
        
        if (!file_exists($originPath)) {
            return;
        }
        
        unlink($originPath);
    }
        
    public function isLinkedToNode($originId, $targetId)
    {
        $this->initialize();
        
        $originPath = $this->buildNodePath($originId);
        
        $linkPath = $originPath . '/' . $targetId;
        
        return file_exists($linkPath);
    }
    
    public function getLinkedNodes($nodeId)
    {
        $this->initialize();
        
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
        $this->initialize();
        
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
            throw new \Exception();
        }
        
        return $nodeId;
    }
        
    public function getNodeValue($nodeId)
    {
        $this->initialize();
        
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
    
    public function getValue($isFile, $content)
    {
        $this->initialize();
        
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
    
    private function initialize()
    {
        if ($this->initialized) {
            return;
        }
        
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

            $targetPath = $valuePath . '/' . basename($originPath);
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
