<?php
namespace Comode\syntax\node;

use Comode\graph\INode;

interface IFilter
{
    public function byType(INode $node, $type);
}