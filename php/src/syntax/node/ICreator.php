<?php
namespace Comode\syntax\node;

use Comode\graph\INode;

interface ICreator
{
    public function createNode($type, $value = null);
}