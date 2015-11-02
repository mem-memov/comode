<?php
namespace Comode\syntax;

use Comode\graph\INode;

abstract class Compliment implements ICompliment
{
    protected $node;
    
    public function __construct(INode $node)
    {
        $this->node = $node;
    }
    
    public function hasArgument(INode $argumentNode)
    {
        return $this->node->hasNode($argumentNode);
    }
    
    public function addArgument(INode $argumentNode)
    {
        if ($this->hasArgument($argumentNode)) {
            throw new exception\ArgumentComplimentsMayNotRepeat();
        }
        
        $this->node->addNode($argumentNode);
        $argumentNode->addNode($this->node);
    }
    
    public function getValue()
    {
        return $this->node->getValue()->getContent();
    }
    
    abstract public function isFile();
}