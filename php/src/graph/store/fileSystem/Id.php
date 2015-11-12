<?php
namespace Comode\graph\store\fileSystem;

class Store implements IId
{
    public function next()
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
}