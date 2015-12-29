<?php
namespace Comode\syntax\node\sequence\malformed\exception;

use Comode\syntax\node\INode;

class TargetNodeNotOne extends Exception
{
    public function __construct(
        INode $commonNode, 
        $sequenceType, 
        INode $originNode, 
        INode $originNextNode, 
        $targetNextNodeCount
    ) {
        $message = 'More than one target node found for the origin node ' 
            . $originNode->getId() 
            . '->' . $originNextNode->getId() 
            . '->' . $targetNextNode->getId() 
            . '-> ???.'
        ;
        
        parent::__construct($message, $commonNode, $sequenceType);
    }
}