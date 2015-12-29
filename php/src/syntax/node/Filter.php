<?php
namespace Comode\syntax\node;

use Comode\graph\INode;

final class Filter implements IFilter
{
    private $typeChecker;
    
    public function __construct(ITypeChecker $typeChecker)
    {
        $this->typeChecker = $typeChecker;
    }
    
    public function byType(INode $node, $type)
    {
        $linkedNodes = $this->node->getNodes();

        $selectedNodes = [];
        
        foreach ($linkedNodes as $linkedNode) {
            if ($this->typeChecker->ofType($linkedNode, $type)) {
                $selectedNodes[] = $linkedNode;
            }
        }
        
        return $selectedNodes;
    }
    
    public function byNode()
    {
        
    }
}