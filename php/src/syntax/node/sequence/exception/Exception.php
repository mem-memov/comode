<?php
namespace Comode\syntax\node\sequence\exception;

use Comode\syntax\node\INode;

class Exception extends \Exception
{
    public function __construct($message, INode $commonNode, $sequenceType)
    {
        parent::__construct($message . ' In sequence of type ' . $sequenceType . ' attached to node ' . $commonNode->getId());
    }
}