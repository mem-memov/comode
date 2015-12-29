<?php
namespace Comode\syntax\node\type;

use Comode\syntax\node\INode;

interface IChecker
{
    public function addType(INode $node, $type);
    public function removeType(INode $node, $type);
    public function ofType(INode $node, $type);
}