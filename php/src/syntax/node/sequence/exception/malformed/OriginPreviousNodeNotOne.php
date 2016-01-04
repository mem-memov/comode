<?php
namespace Comode\syntax\node\sequence\exception\malformed;

use Comode\syntax\node\INode;

class OriginPreviousNodeNotOne extends Exception
{
    public function __construct(INode $commonNode, $sequenceType, INode $originNode)
    {
        $message = 'More than one previous node for the origin node ' . $originNode->getId() . '.';
        parent::__construct($message, $commonNode, $sequenceType);
    }
}