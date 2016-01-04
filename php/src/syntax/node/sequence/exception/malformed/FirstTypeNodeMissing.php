<?php
namespace Comode\syntax\node\sequence\exception\malformed;

use Comode\syntax\node\INode;

class FirstTypeNodeMissing extends Exception
{
    public function __construct(INode $commonNode, $sequenceType, INode  $firstNextNode)
    {
        $message = 'No type node found for the first next node ' . $firstNextNode->getId() . '.';
            
        parent::__construct($message, $commonNode, $sequenceType);
    }
}