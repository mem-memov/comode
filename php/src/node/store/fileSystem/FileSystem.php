<?php
namespace Comode\node\store\fileSystem;

use Comode\node\store\IStore;
use Comode\node\store\fileSystem\IOs;

class FileSystem implements IStore
{
	private $path;
	private $idFile = 'lastId';
	private $os;
	
	public function __construct($path, IOs $os)
	{
		$this->path = $path;
		$this->os = $os;
	}
	
	public function itemExists($id)
	{
		$path = $this->path . '/' . $id;
		return file_exists($path);
	}
	
	public function makeItem()
	{
		$id = $this->nextId();

		$path = $this->path . '/' . $id;
		mkdir($path);
		
		return $id;
	}
	
	public function linkItems($fromId, $toId)
	{
		$fromPath = $this->path . '/' . $fromId . '/' . $toId;
		
		if (file_exists($fromPath)) {
			return;
		}
		
		$toPath = $this->path . '/' . $toId;
		$this->os->symlink($toPath, $fromPath);
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