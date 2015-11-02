<?php
namespace Comode\syntax\operation;

use Comode\graph\IFactory as IGraphFactory;
use Comode\syntax\node\IFactory as INodeFactory;
use Comode\syntax\IPredicate;
use Comode\syntax\IQuestion;

use Comode\syntax\node\IPredicate as IPredicateNode;
use Comode\syntax\node\IQuestion as IQuestionNode;
use Comode\syntax\node\IArgument as IArgumentNode;


class ArgumentNodeProvider implements IArgumentNodeProvider
{
    private $graphFactory;
    private $nodeFactory;
    private $predicate;
    private $question;
    private $predicateNode;
    private $questionNode;

    public function __construct(
        IGraphFactory $graphFactory, 
        INodeFactory $nodeFactory, 
        IPredicate $predicate, 
        IQuestion $question
    ) {
        $this->graphFactory = $graphFactory;
        $this->nodeFactory = $nodeFactory;
        $this->predicate = $predicate;
        $this->question = $question;
    }
    
    public function setPredicateNode(IPredicateNode $predicateNode)
    {
        $this->predicateNode = $predicateNode;
    }
    
    public function setQuestionNode(IQuestionNode $questionNode)
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
            
            $argumentNode = $this->nodeFactory->createArgumentNode();
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
            if ($commonNode instanceof \Comode\syntax\node\IArgument) {
                $argumentNodes[] = $commonNode;
            }
        }
        
        return $argumentNodes;
    }
    
    private function bindToPredicateAnQuestion(IArgumentNode $argumentNode)
    {
        $argumentNode->addNode($this->predicateNode);
        $this->predicateNode->addNode($argumentNode);
        
        $argumentNode->addNode($this->questionNode);
        $this->questionNode->addNode($argumentNode);
    }

}