<?php
namespace Comode\syntax\node\sequence;

use Comode\syntax\node\INode;

interface IFactory
{
    public function getComplimentSequence(INode $node);
}