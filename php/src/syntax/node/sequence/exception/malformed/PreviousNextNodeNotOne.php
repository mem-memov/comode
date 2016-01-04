<?php
namespace Comode\syntax\node\sequence\exception\malformed;

use Comode\syntax\node\INode;

class PreviousNextNodeNotOne extends Exception
{
    public function __construct(INode $commonNode, $sequenceType, INode $previousNode, $nextNodeCount)
    {
        $message = 'More than one next node (' . $nextNodeCount . ') for the previous node ' . $previousNode->getId() . '.';
        parent::__construct($message, $commonNode, $sequenceType);
    }
}