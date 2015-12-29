<?php
namespace Comode\syntax\node\sequence\malformed\exception;

use Comode\syntax\node\INode;

class TargetNextNodeNotOne extends Exception
{
    public function __construct(
        INode $commonNode, 
        $sequenceType, 
        INode $originNode, 
        INode $originNextNode, 
        $targetNextNodeCount
    ) {
        $message = 'Origin ' . $originNode->getId() 
            . ' next node ' . $originNextNode->getId() 
            . ' has more than one(' . $targetNextNodeCount . ') target next nodes.'
        ;
        
        parent::__construct($message, $commonNode, $sequenceType);
    }
}