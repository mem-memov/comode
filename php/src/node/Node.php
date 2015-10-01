<?php
namespace Comode\node;

class Node implements INode
{
	private $fileSystem;
	private $id;
	
	public function __construct(IFileSystem $fileSystem, $id = null)
	{
		$this->fileSystem = $fileSystem;
		
		if (is_null($id)) {
			$id = $this->fileSystem->makeDirectory();
		} else {
			if (!$this->fileSystem->directoryExists($id)) {
				throw new NoIdWhenRetrievingNode();
			}
		}
		
		$this->id = $id;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function addNode($id = null)
	{
		$addedNode = new Node($this->fileSystem, $id);
		$this->fileSystem->addLink($this->id, $addedNode->getId());
	}
}