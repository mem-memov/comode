<?php
namespace Comode\syntax\node\sequence\malformed\exception;

use Comode\syntax\node\INode;

class PreviousNextNodeMissing extends Exception
{
    public function __construct(INode $commonNode, $sequenceType, INode $previousNode)
    {
        $message = 'No next node found for the previous node ' . $previousNode->getId() . '.';
        parent::__construct($message, $commonNode, $sequenceType);
    }
}