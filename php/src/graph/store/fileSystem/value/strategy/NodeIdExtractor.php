<?php
namespace Comode\graph\store\fileSystem\value\strategy;

use Comode\graph\store\exception\ValueMustBeLinkedToOneNode;

class NodeIdExtractor extends INodeIdExtractor
{
    public function extractId(array $nodeIds)
    {
        $nodeCount = count($nodeIds);

        if ($nodeCount == 0) {
            $nodeId = null;
        } elseif ($nodeCount == 1) {
            $nodeId = (int)$nodeIds[0];
        } else {
            throw new ValueMustBeLinkedToOneNode('Value with content has too many nodes: ' . $nodeCount);
        }
        
        return $nodeId;
    }
}