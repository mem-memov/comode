<?php
namespace Comode\syntax\node\sequence\malformed\exception;

use Comode\syntax\node\INode;

class FirstNextNodeNotOne extends Exception
{
    public function __construct(INode $commonNode, $sequenceType, $firstNextNodeCount)
    {
        $message = 'More than one first next node (' . $firstNextNodeCount . ') in sequence.';
        parent::__construct($message, $commonNode, $sequenceType);
    }
}