<?php
namespace Comode\syntax\node\sequence\exception\malformed;

use Comode\syntax\node\INode;

class FirstTypeNodeNotOne extends Exception
{
    public function __construct(
        INode $commonNode, 
        $sequenceType, 
        INode $firstNextNode, 
        $typeNodeCount
    ) {
        $message = 'More than one type node (' . $typeNodeCount . ') found for the first next node ' . $firstNextNode->getId();
        
        parent::__construct($message, $commonNode, $sequenceType);
    }
}