<?php
namespace Comode\syntax\node\type;

use Comode\syntax\node\INode;

interface ISpace
{
    public function getTypeNode($type);
    public function findTypeNode(INode $node);
}