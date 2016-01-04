<?php
namespace Comode\syntax\node\sequence\exception\malformed;

use Comode\syntax\node\INode;

class TargetPreviousNodeNotOne extends Exception
{
    public function __construct(
        INode $commonNode, 
        $sequenceType, 
        INode $originNode, 
        INode $originPreviousNode, 
        $targetPreviousNodeCount
    ) {
        $message = 'Origin ' . $originNode->getId() 
            . ' previous node ' . $originPreviousNode->getId() 
            . ' has more than one(' . $targetPreviousNodeCount . ') target previous nodes.'
        ;
        
        parent::__construct($message, $commonNode, $sequenceType);
    }
}