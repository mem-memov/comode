<?php
namespace Comode\node\store;

interface IStore
{
	public function itemExists($id);
	public function createItem();
	public function linkItems($fromId, $toId);
}