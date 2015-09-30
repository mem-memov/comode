<?php
namespace Comode;

interface INode
{
	public function getId();
	public function addNode($id = null);
}