<?php

namespace Comode\node\store;

use Comode\node\value\IValue;

class FileSystem implements IStore {

    private $path;
    private $graphPath;
    private $valuePath;
    private $valueToNodeIndexPath;
    private $nodeToValueIndexPath;
    private $idFile = 'lastId';

    public function __construct($path) {
        $this->path = $path;

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

    public function nodeExists(INode $node) {
        $path = $this->graphPath . '/' . $node->getId();
        return file_exists($path);
    }

    public function valueExists(IValue $value) {
        $path = $this->valuePath . '/' . $this->hashValue($value);
        return file_exists($path);
    }

    public function createNode() {
        $id = $this->nextId();

        $nodePath = $this->graphPath . '/' . $id;

        mkdir($itemPath, 0777, true);

        return new Node($id);
    }

    public function createValue($content) {
        $isFile = file_exists($content);

        if ($isFile) {
            $hash = $this->hashFile($content);
        } else {
            $hash = $this->hashString($content);
        }

        $valuePath = $this->valuePath . '/' . $hash;
        if (!file_exists($valuePath)) {
            mkdir($valuePath, 0777, true);
        }

        if ($isFile) {
            $fromPath = $content;
            $toPath = $valuePath . basename($content);
            copy($fromPath, $toPath);
            $value = new Value($isFile, $toPath);
        } else {
            $path = $valuePath . '/' . $this->nameStringValueFile($hash);
            file_put_contents($path, $content);
            $value = new Value($isFile, $content);
        }
        
        return $value;
    }

    public function bindValueToNode(INode $node, IValue $value) {
        
    }

    public function createId(IValue $value = null) {
        $id = $this->nextId();

        $itemPath = $this->graphPath . '/' . $id;
        mkdir($itemPath, 0777, true);

        if (!is_null($value)) {
            $valueHash = $value->hash();

            $valuePath = $this->valuePath . '/' . $valueHash;
            if (!file_exists($valuePath)) {
                mkdir($valuePath, 0777, true);
            }
            $content = $value->get();
            if (file_exists($content)) {
                copy($content, $valuePath . basename($content));
            } else {
                file_put_contents($valuePath . '/' . $valueHash . '.txt', $content);
            }

            $valueToNodeIndexPath = $this->valueToNodeIndexPath . '/' . $valueHash;
            if (!file_exists($valueToNodeIndexPath)) {
                mkdir($valueToNodeIndexPath, 0777, true);
            }
            symlink($itemPath, $valueToNodeIndexPath . '/' . $id);

            $nodeToValueIndexPath = $this->nodeToValueIndexPath . '/' . $id;
            if (!file_exists($nodeToValueIndexPath)) {
                mkdir($nodeToValueIndexPath, 0777, true);
            }
            symlink($valuePath, $nodeToValueIndexPath . '/' . $valueHash);
        }

        return $id;
    }

    public function linkIds($fromId, $toId) {
        $fromPath = $this->graphPath . '/' . $fromId . '/' . $toId;

        if (file_exists($fromPath)) {
            return;
        }

        $toPath = $this->graphPath . '/' . $toId;
        symlink($toPath, $fromPath);
    }

    public function getChildIds($id) {
        $path = $this->graphPath . '/' . $id;
        $offset = strlen($path) + 1;

        $childPaths = glob($path . '/*');

        $childIds = [];
        foreach ($childPaths as $childPath) {
            $childId = (int) substr($childPath, $offset);
            array_push($childIds, $childId);
        }

        return $childIds;
    }

    public function getIdsByValue(IValue $value) {
        $path = $this->valueToNodeIndexPath . '/' . $value->hash();
        $offset = strlen($path) + 1;

        $paths = glob($path . '/*');

        $ids = [];
        foreach ($paths as $path) {
            $id = (int) substr($path, $offset);
            array_push($ids, $id);
        }

        return $ids;
    }

    public function getValue($id) {
        $nodeToValueIndexPath = $this->nodeToValueIndexPath . '/' . $id;

        $paths = glob($nodeToValueIndexPath . '/*');

        if (empty($paths)) {
            throw new ValueNotFound();
        }

        $link = $paths[0];

        $valueDirectory = readlink($link);

        $valueHash = basename($valueDirectory);

        $valuePaths = glob($valueDirectory . '/*');

        $valuePath = $valuePaths[0];

        $fileName = basename($valuePath);

        if ($fileName == $valueHash . '.txt') {
            $content = file_get_contents($valuePath);
            $value = new Value(false, $content);
        } else {
            $value = new Value(false, $valuePath);
        }

        return $value;
    }

    private function nextId() {
        $lastIdPath = $this->path . '/' . $this->idFile;

        if (!file_exists($lastIdPath)) {
            file_put_contents($lastIdPath, 0);
        }

        $lastId = file_get_contents($lastIdPath);

        $nextId = $lastId + 1;

        file_put_contents($lastIdPath, $nextId);

        return (int) $nextId;
    }

    private function nameStringValueFile($hash) {
        return $hash . '.txt';
    }

    private function hashValue(IValue $value) {
        if ($value->isFile()) {
            $hash = $this->hashFile($value->getContent());
        } else {
            $hash = $this->hashString($value->getContent());
        }

        return $hash;
    }

    private function hashValueContent($content) {
        if (file_exists($content)) {
            $hash = $this->hashFile($content);
        } else {
            $hash = $this->hashString($content);
        }

        return $hash;
    }

    private function hashFile($path) {
        return hash_file('md5', $path);
    }

    private function hashString($string) {
        return md5($string);
    }

}
