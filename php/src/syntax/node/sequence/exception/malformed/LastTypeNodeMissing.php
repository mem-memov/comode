<?php
namespace Comode\syntax\node\sequence\malformed\exception;

use Comode\syntax\node\INode;

class LastTypeNodeMissing extends Exception
{
    public function __construct(INode $commonNode, $sequenceType, INode $lastPreviousNode)
    {
        $message = 'No type node found for the last previous node ' . $lastPreviousNode->getId() . '.';
            
        parent::__construct($message, $commonNode, $sequenceType);
    }
}