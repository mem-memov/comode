<?php
namespace Comode\node\store;

use Comode\node\value\IValue;

interface IStore
{
	public function itemExists($id);
	public function createItem(IValue $value = null);
	public function linkItems($fromId, $toId);
}