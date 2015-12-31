<?php
namespace Comode\syntax\node\type;

use Comode\graph\INode;

interface IChecker
{
    public function setType(INode $node, $type);
    public function removeType(INode $node, $type);
    public function ofType(INode $node, $type);
}