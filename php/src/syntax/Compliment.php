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
    
    public function getId()
    {
        return $this->node->getId();
    }
    
    public function hasArgument(node\IArgument $argumentNode)
    {
        return $this->node->hasNode($argumentNode);
    }
    
    public function addArgument(node\IArgument $argumentNode)
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