<?php
namespace Comode\syntax\node\sequence\exception\malformed;

use Comode\syntax\node\INode;
use Comode\syntax\node\sequence\exception\Exception as SequenceException;

class Exception extends SequenceException
{
    public function __construct($message, INode $commonNode, $sequenceType)
    {
        $message = 'Sequence malformed. ' . $message;
        parent::__construct($message, $commonNode, $sequenceType);
    }
}