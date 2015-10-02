<?php
namespace Comode\node;

use Comode\node\store\IStore;
use Comode\node\value\IValue;

class Node implements INode
{
	private $store;
	private $id;
	private $value;
	
	public function __construct(IStore $store, $id = null, IValue $value = null)
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
	
	public function addNode(INode $node)
	{
		$this->store->linkItems($this->id, $node->getId());
	}
}