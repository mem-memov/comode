<?php
namespace Comode\syntax\node\exception;

class NodeOfWrongType extends Exception
{
    public function __construct($nodeId, $type)
    {
        $message = 'Node ' . $nodeId . ' has wrong type. Required type is ' . $type . '.';
        
        parent::__construct($message);
    }
}