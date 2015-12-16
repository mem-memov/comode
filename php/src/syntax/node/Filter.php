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
    
    public function byTypes(INode $node, array $types)
    {
        $linkedNodes = $this->node->getNodes();

        $selectedNodes = [];
        
        foreach ($linkedNodes as $linkedNode) {
            
            $typesMached = true;
            foreach ($types as $type) {
                $typesMached = $typesMached && $this->typeChecker->ofType($linkedNode, $type);
                if (!$typesMached) {
                    break;
                }
            }
            
            if ($typesMached) {
                $selectedNodes[] = $linkedNode;
            }
        }
        
        return $selectedNodes;
    }
}