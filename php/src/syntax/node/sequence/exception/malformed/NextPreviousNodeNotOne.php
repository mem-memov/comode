<?php
namespace Comode\syntax\node\sequence\exception\malformed;

use Comode\syntax\node\INode;

class NextPreviousNodeNotOne extends Exception
{
    public function __construct(INode $commonNode, $sequenceType, INode $nextNode, $previousNodeCount)
    {
        $message = 'More than one previous node (' . $previousNodeCount . ') for the next node ' . $nextNode->getId() . '.';
        parent::__construct($message, $commonNode, $sequenceType);
    }
}