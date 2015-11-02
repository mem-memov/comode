<?php
namespace Comode\syntax\node;

use Comode\graph\INode;

abstract class Node
{
    private $node;
    
    public function __construct(INode $node)
    {
        $this->node = $node;
    }
    
    public function getId()
    {
        return $this->node->getId();
    }
    
    public function addNode(INode $node)
    {
        return $this->node->addNode($node);
    }
    
    public function getNodes()
    {
        return $this->node->getNodes();
    }
    
    public function hasNode(INode $node)
    {
        return $this->node->hasNode($node);
    }
    
    public function getValue()
    {
        return $this->node->getValue();
    }
    
    public function getCommonNodes(INode $node)
    {
        return $this->node->getCommonNodes($node);
    }
}