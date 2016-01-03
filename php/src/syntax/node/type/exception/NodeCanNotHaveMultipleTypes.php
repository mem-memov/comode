<?php
namespace Comode\syntax\node\type\exception;

use Comode\syntax\node\INode;

class NodeCanNotHaveMultipleTypes extends Exception
{
    public function __construct(INode $node, $typeNodeCount)
    {
        $message = 'Node ' . $node->getId() . ' has more than one type node attached (' . $typeNodeCount . ').';
        
        parent::__construct($message);
    }
}