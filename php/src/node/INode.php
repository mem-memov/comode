<?php
namespace Comode\node;

interface INode
{
	public function getId();
	public function addNode($id = null);
}