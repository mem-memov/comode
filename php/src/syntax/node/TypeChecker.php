<?php
namespace Comode\syntax\node;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

final class TypeChecker implements ITypeChecker
{
    private $typeSpace;
    
    public function __construct(ITypeSpace $typeSpace)
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