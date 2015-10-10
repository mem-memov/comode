<?php
namespace Comode\syntax;

use Comode\graph\INode;

class StringAnswer implements IAnswer
{
    private $node;
    private $string;
    
    public function __construct($string, INode $node)
    {
        $this->string = $string;
        $this->node = $node;
    }
}