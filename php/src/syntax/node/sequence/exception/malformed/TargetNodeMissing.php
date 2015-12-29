<?php
namespace Comode\syntax\node\sequence\malformed\exception;

use Comode\syntax\node\INode;

class TargetNodeMissing extends Exception
{
    public function __construct(
        INode $commonNode, 
        $sequenceType, 
        INode $originNode, 
        INode $originNextNode, 
        INode $targetNextNode
    ) {
        $message = 'No target node found for the origin node ' 
            . $originNode->getId() 
            . '->' . $originNextNode->getId() 
            . '->' . $targetNextNode->getId() 
            . '-> X.'
        ;
            
        parent::__construct($message, $commonNode, $sequenceType);
    }
}