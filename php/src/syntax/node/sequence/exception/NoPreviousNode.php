<?php
namespace Comode\syntax\node\sequence\exception;

use Comode\syntax\node\INode;

final class NoNextNode extends Exception
{
    public function __construct(INode $commonNode, $sequenceType, INode $originNode)
    {
        $message = 'Sequence node ' . $node->getId() . ' has no next node.';
        parent::__construct($message, $commonNode, $sequenceType);
    }
}