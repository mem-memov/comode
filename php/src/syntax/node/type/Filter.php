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
    
    public function byType(INode $node, $type, $class)
    {
        $linkedNodes = $node->getNodes();

        $selectedNodes = [];
        
        foreach ($linkedNodes as $linkedNode) {
            $selectedNode = new $class($linkedNode);
            if ($this->typeChecker->ofType($selectedNode, $type)) {
                $selectedNodes[] = $selectedNode;
            }
        }
        
        return $selectedNodes;
    }
}