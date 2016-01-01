<?php
namespace Comode\syntax\node\type;

use Comode\syntax\node\INode;

final class Checker implements IChecker
{
    private $typeSpace;
    
    public function __construct(ISpace $typeSpace)
    {
        $this->typeSpace = $typeSpace;
    }
    
    public function setType(INode $node, $type)
    {
        if ($this->ofType($node, $type)) {
            return;
        }
        
        $typeNode = $this->typeSpace->getTypeNode($type);
        $node->addNode($typeNode);
    }
    
    public function removeType(INode $node, $type)
    {
        if (!$this->ofType($node, $type)) {
            return;
        }
        
        $typeNode = $this->typeSpace->getTypeNode($type);
        $node->removeNode($typeNode);
    }

    public function ofType(INode $node, $type)
    {
        $typeNode = $this->typeSpace->getTypeNode($type);
        return $node->hasNode($typeNode);
    }
}