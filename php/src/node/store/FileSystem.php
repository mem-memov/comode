<?php
namespace Comode\node\store;

use Comode\node\value\IValue;

class FileSystem implements IStore
{
	private $path;
    private $graphPath;
    private $valuePath;
	private $idFile = 'lastId';

	public function __construct($path)
	{
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
	}
	
	public function itemExists($id)
	{
            $path = $this->graphPath . '/' . $id;
            return file_exists($path);
	}
	
	public function createItem(IValue $value = null)
	{
		$id = $this->nextId();

		$itemPath = $this->graphPath . '/' . $id;
		mkdir($itemPath, 0777, true);
		
		if (!is_null($value)) {
		    $hashPath = $this->valuePath . '/' . $value->hash();
		    mkdir($hashPath, 0777, true);
		}
		
		return $id;
	}
	
	public function linkItems($fromId, $toId)
	{
            $fromPath = $this->graphPath . '/' . $fromId . '/' . $toId;

            if (file_exists($fromPath)) {
                return;
            }
            
            mkdir($valuePath, 0777, true);

            $toPath = $this->graphPath . '/' . $toId;
            symlink($toPath, $fromPath);
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
}