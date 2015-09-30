<?php
namespace Comode;

class FileSystem implements IFileSystem
{
	private $path;
	private $idFile = 'lastId';
	
	public function __construct($path)
	{
		$this->path = $path;
	}
	
	public function directoryExists($id)
	{
		$path = $this->path . '/' . $id;
		return file_exists($path);
	}
	
	public function makeDirectory()
	{
		$id = $this->nextId();

		$path = $this->path . '/' . $id;
		mkdir($path);
		
		return $id;
	}
	
	public function addLink($fromId, $toId)
	{
		$fromPath = $this->path . '/' . $fromId . '/' . $toId;
		
		if (file_exists($fromPath)) {
			return;
		}
		
		$toPath = $this->path . '/' . $toId;
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