<?php
namespace Comode\syntax\node\sequence\malformed\exception;

use Comode\syntax\node\INode;

class LastPreviousNodeNotOne extends Exception
{
    public function __construct(INode $commonNode, $sequenceType, $lastPreviousNodeCount)
    {
        $message = 'More than one last previous node (' . $lastPreviousNodeCount . ') in sequence.';
        parent::__construct($message, $commonNode, $sequenceType);
    }
}