<?php
namespace Comode\syntax\node;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

class Factory implements IFactory
{
    private $graphFactory;
    private $map;
    
    public function __construct(IGraphFactory $graphFactory, $spaceDirectory)
    {
        $this->graphFactory = $graphFactory;
        $this->setMap($spaceDirectory);
    }
    
    public function createClauseNode()
    {
        $node = $this->graphFactory->createNode();
        
        $node->addNode($this->map['clause']);
        
        return new Clause($node);
    }
    
    public function getClauseNodes(INode $node)
    {
        $linkedNodes = $this->selectLinkedNodes($node, 'clause');
        
        $clauseNodes = [];
        
        foreach ($linkedNodes as $linkedNode) {
            $clauseNodes[] = new Clause($linkedNode);
        }
        
        return $clauseNodes;
    }
    
    public function createPredicateNode($structure)
    {
        $node = $this->graphFactory->createNode($structure);
        
        $node->addNode($this->map['predicate']);
        
        return new Predicate($node);
    }
    
    public function getPredicateNodes(INode $node)
    {
        $linkedNodes = $this->selectLinkedNodes($node, 'predicate');
        
        $predicateNodes = [];
        
        foreach ($linkedNodes as $linkedNode) {
            $predicateNodes[] = new Predicate($linkedNode);
        }
        
        return $predicateNodes;
    }
    
    public function createArgumentNode()
    {
        $node = $this->graphFactory->createNode();
        
        $node->addNode($this->map['argument']);
        
        return new Argument($node);
    }
    
    public function getArgumentNodes(INode $node)
    {
        $linkedNodes = $this->selectLinkedNodes($node, 'argument');
        
        $argumentNodes = [];
        
        foreach ($linkedNodes as $linkedNode) {
            $argumentNodes[] = new Argument($linkedNode);
        }
        
        return $argumentNodes;
    }
    
    public function createQuestionNode(array $structure)
    {
        $node = $this->graphFactory->createNode($structure);
        
        $node->addNode($this->map['question']);
        
        return new Question($node);
    }
    
    public function getQuestionNodes(INode $node)
    {
        $linkedNodes = $this->selectLinkedNodes($node, 'question');
        
        $questionNodes = [];
        
        foreach ($linkedNodes as $linkedNode) {
            $questionNodes[] = new Question($linkedNode);
        }
        
        return $questionNodes;
    }
    
    public function createComplimentNode()
    {
        $node = $this->graphFactory->createNode();
        
        $node->addNode($this->map['compliment']);
        
        return new Compliment($node);
    }
    
    public function getComplimentNodes(INode $node)
    {
        $linkedNodes = $this->selectLinkedNodes($node, 'compliment');
        
        $complimentNodes = [];
        
        foreach ($linkedNodes as $linkedNode) {
            $complimentNodes[] = new Compliment($linkedNode);
        }
        
        return $complimentNodes;
    }
    
    public function createAnswerNode(array $structure)
    {
        $node = $this->graphFactory->createNode($structure);
        
        $node->addNode($this->map['answer']);
        
        return new Answer($node);
    }

    public function getAnswerNodes(INode $node)
    {
        $linkedNodes = $this->selectLinkedNodes($node, 'answer');
        
        $answerNodes = [];
        
        foreach ($linkedNodes as $linkedNode) {
            $answerNodes[] = new Answer($linkedNode);
        }
        
        return $answerNodes;
    }
    
    private function setMap($spaceDirectory)
    {
        if (!file_exists($spaceDirectory)) {
            mkdir($spaceDirectory, 0777, true);
        }
        
        $mappingPath = $spaceDirectory . '/spaceMap.php';
        
        if (!file_exists($mappingPath)) {
            $map = [
                'clause' => $this->graphFactory->createNode()->getId(),
                'predicate' => $this->graphFactory->createNode()->getId(),
                'argument' => $this->graphFactory->createNode()->getId(),
                'question' => $this->graphFactory->createNode()->getId(),
                'compliment' => $this->graphFactory->createNode()->getId(),
                'answer' => $this->graphFactory->createNode()->getId()
            ];
            $fileContent = '<?php return ' . var_export($map, true) . ';';
            file_put_contents($mappingPath, $fileContent);
        }
        
        $map = require($mappingPath);
        
        foreach ($map as $space => $nodeId) {
            $map[$space] = $this->graphFactory->readNode($nodeId);
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
    
    private function isNodeOfType($node, $type)
    {
        $typeNode = $this->map[$type];
        
        return $node->hasNode($typeNode);
    }
}