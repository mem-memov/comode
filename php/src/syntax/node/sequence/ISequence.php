<?php
namespace Comode\syntax\node\sequence;

use Comode\syntax\node\INode;

interface ISequence
{
    public function firstNodePath();
    public function lastNodePath();
    public function nextNodePath(INode $originNode);
    public function previousNodePath(INode $originNode);
    public function append(INode $node);
}