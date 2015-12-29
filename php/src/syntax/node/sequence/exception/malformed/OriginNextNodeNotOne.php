<?php
namespace Comode\syntax\node\sequence\malformed\exception;

use Comode\syntax\node\INode;

class OriginNextNodeNotOne extends Exception
{
    public function __construct(INode $commonNode, $sequenceType, INode $originNode)
    {
        $message = 'More than one next node for the origin node ' . $originNode->getId() . '.';
        parent::__construct($message, $commonNode, $sequenceType);
    }
}