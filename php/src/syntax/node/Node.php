<?php
namespace Comode\syntax\node;

use Comode\graph\INode as IGraphNode;

abstract class Node implements INode
{
    private $node;

    public function __construct(IGraphNode $node)
    {
        $this->node = $node;
    }
    
    public function getGraphNode()
    {
        return $this->node;
    }
    
    public function getId()
    {
        return $this->node->getId();
    }
    
    public function addNode(INode $node)
    {
        return $this->node->addNode($node->getGraphNode());
    }
    
    public function removeNode(INode $node)
    {
        return $this->node->removeNode($node->getGraphNode());
    }
    
    public function getNodes()
    {
        return $this->node->getNodes();
    }
    
    public function hasNode(INode $node)
    {
        return $this->node->hasNode($node->getGraphNode());
    }
    
    public function getValue()
    {
        return $this->node->getValue();
    }
    
    public function getCommonNodes(INode $node)
    {
        return $this->node->getCommonNodes($node->getGraphNode());
    }
}