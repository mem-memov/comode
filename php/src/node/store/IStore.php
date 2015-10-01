<?php
namespace Comode\node\store;

interface IStore
{
	public function itemExists($id);
	public function makeItem();
	public function linkItems($fromId, $toId);
}