<?php
namespace Comode\syntax;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

class SpaceMap implements ISpaceMap
{
    private $graphFactory;
    private $map;
    
    public function __construct(IGraphFactory $graphFactory, $spaceDirectory)
    {
        $this->graphFactory = $graphFactory;
        $this->setMap($graphFactory, $spaceDirectory);
    }
    
    public function createClauseNode()
    {
        $node = $this->graphFactory->createNode();
        return $this->createNodeOfType($node, 'clause');
    }
    
    public function isClauseNode(INode $node)
    {
        return $this->isNodeOfType($node, 'clause');
    }

    public function getClauseNodes(INode $node)
    {
        return $this->selectLinkedNodes($node, 'clause');
    }
    
    public function createPredicateNode($predicateString)
    {
        $node = $this->graphFactory->createStringNode($predicateString);
        return $this->createNodeOfType($node, 'predicate');
    }
    
    public function isPredicateNode(INode $node)
    {
        return $this->isNodeOfType($node, 'predicate');
    }
    
    public function getPredicateNodes(INode $node)
    {
        return $this->selectLinkedNodes($node, 'predicate');
    }
    
    public function createArgumentNode()
    {
        $node = $this->graphFactory->createNode();
        return $this->createNodeOfType($node, 'argument');
    }
    
    public function isArgumentNode(INode $node)
    {
        return $this->isNodeOfType($node, 'argument');
    }
    
    public function getArgumentNodes(INode $node)
    {
        return $this->selectLinkedNodes($node, 'argument');
    }
    
    public function createQuestionNode($questionString)
    {
        $node = $this->graphFactory->createStringNode($questionString);
        return $this->createNodeOfType($node, 'question');
    }
    
    public function isQuestionNode(INode $node)
    {
        return $this->isNodeOfType($node, 'question');
    }
    
    public function getQuestionNodes(INode $node)
    {
        return $this->selectLinkedNodes($node, 'question');
    }
    
    public function createStringComplimentNode($string)
    {
        $node = $this->graphFactory->createStringNode($string);
        return $this->createNodeOfType($node, 'compliment');
    }
    
    public function createFileComplimentNode($path)
    {
        $node = $this->graphFactory->createFileNode($path);
        return $this->createNodeOfType($node, 'compliment');
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
    
    private function createNodeOfType($node, $type)
    {
        $typeNode = $this->map[$type];

        $node->addNode($typeNode);
        
        return $node;
    }
}