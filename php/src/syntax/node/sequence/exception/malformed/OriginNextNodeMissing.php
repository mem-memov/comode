<?php
namespace Comode\syntax\node\sequence\malformed\exception;

use Comode\syntax\node\INode;

class OriginNextNodeMissing extends Exception
{
    public function __construct(INode $commonNode, $sequenceType, INode $originNode)
    {
        $message = 'No next node found for the origin node ' . $originNode->getId() . '.';
        parent::__construct($message, $commonNode, $sequenceType);
    }
}