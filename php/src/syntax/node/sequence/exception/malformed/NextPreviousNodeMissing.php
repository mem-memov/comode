<?php
namespace Comode\syntax\node\sequence\malformed\exception;

use Comode\syntax\node\INode;

class NextPreviousNodeMissing extends Exception
{
    public function __construct(INode $commonNode, $sequenceType, INode $nextNode)
    {
        $message = 'No previous node found for the next node ' . $nextNode->getId() . '.';
        parent::__construct($message, $commonNode, $sequenceType);
    }
}