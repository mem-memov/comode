<?php
namespace Comode\syntax\node\type;

use Comode\syntax\node\INode;

final class Filter implements IFilter
{
    private $typeChecker;
    
    public function __construct(IChecker $typeChecker)
    {
        $this->typeChecker = $typeChecker;
    }
    
    public function byType(INode $node, $type)
    {
        $linkedNodes = $node->getNodes();

        $selectedNodes = [];
        
        foreach ($linkedNodes as $linkedNode) {
            if ($this->typeChecker->ofType($linkedNode, $type)) {
                $selectedNodes[] = $linkedNode;
            }
        }
        
        return $selectedNodes;
    }
}