<?php
namespace Comode\node;

use Comode\node\store\IStore;

class Node implements INode
{
	private $store;
	private $id;
	
	public function __construct(IStore $store, $id = null)
	{
		$this->store = $store;
		
		if (is_null($id)) {
			$id = $this->store->createItem();
		} else {
			if (!$this->store->itemExists($id)) {
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
		$addedNode = new Node($this->store, $id);
		$this->store->linkItems($this->id, $addedNode->getId());
	}
}