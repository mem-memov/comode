<?php
namespace Comode\syntax\node\sequence\exception;

use Comode\syntax\node\INode;

final class Missing extends Exception
{
    public function __construct(INode $commonNode, $sequenceType)
    {
        $message = 'No sequence present.';
        parent::__construct($message, $commonNode, $sequenceType);
    }
}