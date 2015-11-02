<?php
namespace Comode\syntax;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

class SpaceMap implements ISpaceMap
{
    private $map;
    
    public function __construct(IGraphFactory $graphFactory, $spaceDirectory)
    {
        $this->setMap($graphFactory, $spaceDirectory);
    }
    
    public function isClauseNode(INode $node)
    {
        return $this->isNodeOfType($node, 'clause');
    }

    public function getClauseNodes(INode $node)
    {
        return $this->selectLinkedNodes($node, 'clause');
    }
    
    public function isPredicateNode(INode $node)
    {
        return $this->isNodeOfType($node, 'predicate');
    }
    
    public function getPredicateNodes(INode $node)
    {
        return $this->selectLinkedNodes($node, 'predicate');
    }
    
    public function isArgumentNode(INode $node)
    {
        return $this->isNodeOfType($node, 'argument');
    }
    
    public function getArgumentNodes(INode $node)
    {
        return $this->selectLinkedNodes($node, 'argument');
    }
    
    public function isQuestionNode(INode $node)
    {
        return $this->isNodeOfType($node, 'question');
    }
    
    public function getQuestionNodes(INode $node)
    {
        return $this->selectLinkedNodes($node, 'question');
    }
    
    public function isComplimentNode(INode $node)
    {
        return $this->isNodeOfType($node, 'compliment');
    }
    
    public function getComplimentNodes(INode $node)
    {
        return $this->selectLinkedNodes($node, 'compliment');
    }

    private function setMap(IGraphFactory $graphFactory, $spaceDirectory)
    {
        if (!file_exists($spaceDirectory)) {
            mkdir($spaceDirectory, 0777, true);
        }
        
        $mappingPath = $spaceDirectory . '/spaceMap.php';
        
        if (!file_exists($mappingPath)) {
            $map = [
                'clause' => $graphFactory->createNode()->getId(),
                'predicate' => $graphFactory->createNode()->getId(),
                'argument' => $graphFactory->createNode()->getId(),
                'question' => $graphFactory->createNode()->getId(),
                'compliment' => $graphFactory->createNode()->getId()
            ];
            $fileContent = '<?php return ' . var_export($map, true) . ';';
            file_put_contents($mappingPath, $fileContent);
        }
        
        $map = require($mappingPath);
        
        foreach ($map as $space => $nodeId) {
            $map[$space] = $graphFactory->readNode($nodeId);
        }
        
        $this->map = $map;
    }
    
    private function selectLinkedNodes(INode $node, $type)
    {
        $linkedNodes = $node->getNodes();
        
        $selectedNodes = [];
        
        foreach ($linkedNodes as $linkedNode) {
            if ($this->isNodeOfType($linkedNode, $type)) {
                $selectedNodes[] = $linkedNode;
            }
        }
        
        return $selectedNodes;
    }
    
    private function isNodeOfType(INode $node, $type)
    {
        $typeNode = $this->map[$type];
        
        return $node->hasNode($typeNode);
    }
}