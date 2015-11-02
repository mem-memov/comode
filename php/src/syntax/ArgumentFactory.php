<?php
namespace Comode\syntax;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

class ArgumentFactory implements IArgumentFactory
{
    private $graphFactory;
    private $spaceMap;
    private $clauseFactory;
    private $predicateFactory;
    private $questionFactory;
    private $complimentFactory;

    public function __construct(
        IGraphFactory $graphFactory, 
        ISpaceMap $spaceMap,
        IQuestionFactory $questionFactory, 
        IComplimentFactory $complimentFactory
    )
    {
        $this->graphFactory = $graphFactory;
        $this->spaceMap = $spaceMap;
        $this->clauseFactory = $clauseFactory;
        $this->questionFactory = $questionFactory;
        $this->complimentFactory = $complimentFactory;
    }
    
    public function setClauseFactory(IClauseFactory $clauseFactory)
    {
        $this->clauseFactory = $clauseFactory;
    }
    
    public function setPredicateFactory(IPredicateFactory $predicateFactory)
    {
        $this->predicateFactory = $predicateFactory;
    }
    
    public function provideArgument(IPredicate $predicate, IQuestion $question)
    {
        $argumentProvider = new operation\ArgumentNodeProvider($this->graphFactory, $this->spaceMap, $predicate, $question);

        $argumentNode = $argumentProvider->provideArgumentNode();
        
        $argument = $this->makeArgument($argumentNode);

        return $argument;
    }
    
    public function provideArgumentsByClause(INode $clauseNode)
    {
        $argumentNodes = $this->spaceMap->getArgumentNodes($clauseNode);
        
        return $this->makeArguments($argumentNodes);
    }
    
    public function getArgumentsByPredicate(INode $predicateNode)
    {
        $argumentNodes = $this->spaceMap->getArgumentNodes($predicateNode);

        return $this->makeArguments($argumentNodes);
    }
    
    private function makeArguments(array $argumentNodes)
    {
        $arguments = [];
        
        foreach ($argumentNodes as $argumentNode) {
            $arguments[] = $this->makeArgument($argumentNode);
        }
        
        return $arguments;
    }
    
    private function makeArgument($argumentNode)
    {
        return new Argument($this->clauseFactory, $this->predicateFactory, $this->questionFactory, $this->complimentFactory, $argumentNode);
    }
}