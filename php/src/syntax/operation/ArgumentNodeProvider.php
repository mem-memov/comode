<?php
namespace Comode\syntax\operation;

use Comode\graph\IFactory as IGraphFactory;
use Comode\syntax\ISpaceMap;
use Comode\syntax\IPredicate;
use Comode\syntax\IQuestion;

use Comode\graph\INode;


class ArgumentNodeProvider implements IArgumentNodeProvider
{
    private $graphFactory;
    private $spaceMap;
    private $predicate;
    private $question;
    private $predicateNode;
    private $questionNode;

    public function __construct(
        IGraphFactory $graphFactory, 
        ISpaceMap $spaceMap, 
        IPredicate $predicate, 
        IQuestion $question
    ) {
        $this->graphFactory = $graphFactory;
        $this->spaceMap = $spaceMap;
        $this->predicate = $predicate;
        $this->question = $question;
    }
    
    public function setPredicateNode(INode $predicateNode)
    {
        $this->predicateNode = $predicateNode;
    }
    
    public function setQuestionNode(INode $questionNode)
    {
        $this->questionNode = $questionNode;
    }

    public function provideArgumentNode()
    {
        $this->fetchPredicateAndQuestionNodes();

        $argumentNodes = $this->getArgumentNodes();

        $argumentCount = count($argumentNodes);
        
        if ($count > 1) {
            
            throw new exception\PredicateAndQuestionHaveOneCommonArgument('Too many arguments for one predicate and one question: ' . $count);
            
        } elseif ($count == 1) {
            
            $argumentNode = $argumentNodes[0];
            
        } elseif ($count == 0) {
            
            $argumentNode = $this->spaceMap->createArgumentNode();
            $this->bindToPredicateAnQuestion($argumentNode);
            
        }

        return $argumentNode;
    }
    
    private function fetchPredicateAndQuestionNodes()
    {
        $this->predicate->provideArgument($this);
        
        if (is_null($this->predicateNode)) {
            throw new exception\PredicateAndQuestionHaveOneCommonArgument('Predicate node not set.');
        }
        
        $this->question->provideArgument($this);
        
        if (is_null($this->questionNode)) {
            throw new exception\PredicateAndQuestionHaveOneCommonArgument('Question node not set.');
        }
    }
    
    private function getArgumentNodes()
    {
        $commonNodes = $this->predicateNode->getCommonNodes($this->questionNode);
        
        $argumentNodes = [];
        
        foreach ($commonNodes as $commonNode) {
            if ($this->spaceMap->isArgumentNode($commonNode)) {
                $argumentNodes[] = $commonNode;
            }
        }
        
        return $argumentNodes;
    }
    
    private function bindToPredicateAnQuestion(INode $argumentNode)
    {
        $argumentNode->addNode($this->predicateNode);
        $this->predicateNode->addNode($argumentNode);
        
        $argumentNode->addNode($this->questionNode);
        $this->questionNode->addNode($argumentNode);
    }

}