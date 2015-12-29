<?php
namespace Comode\syntax\node\sequence\malformed\exception;

use Comode\syntax\node\INode;

class LastTypeNodeNotOne extends Exception
{
    public function __construct(
        INode $commonNode, 
        $sequenceType, 
        INode $lastPreviousNode, 
        $typeNodeCount
    ) {
        $message = 'More than one type node (' . $typeNodeCount . ') found for the last previous node ' . $lastPreviousNode->getId();
        
        parent::__construct($message, $commonNode, $sequenceType);
    }
}