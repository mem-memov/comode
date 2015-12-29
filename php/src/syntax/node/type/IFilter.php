<?php
namespace Comode\syntax\node\type;

use Comode\syntax\node\INode;

interface IFilter
{
    public function byType(INode $node, $type);
}