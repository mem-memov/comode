<?php
namespace Comode\syntax\node\type\exception;

use Comode\syntax\node\INode;

class NodeHasNoType extends Exception
{
    public function __construct(INode $node)
    {
        $message = 'Node ' . $node->getId() . ' has no type.';
        
        parent::__construct($message);
    }
}