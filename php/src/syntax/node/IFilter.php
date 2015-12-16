<?php
namespace Comode\syntax\node;

use Comode\graph\INode;

interface IFilter
{
    public function byTypes(INode $node, array $types);
}