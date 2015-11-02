<?php
namespace Comode\syntax;

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
        IClauseFactory $clauseFactory,
        IPredicateFactory $predicateFactory,
        IQuestionFactory $questionFactory, 
        IComplimentFactory $complimentFactory
    )
    {
        $this->graphFactory = $graphFactory;
        $this->spaceMap = $spaceMap;
        $this->clauseFactory = $clauseFactory;
        $this->predicateFactory = $predicateFactory;
        $this->questionFactory = $questionFactory;
        $this->complimentFactory = $complimentFactory;
    }
    
    public function provideArgument(IPredicate $predicate, IQiestion $question)
    {
        $argumentProvider = new operation\ArgumentProvider($this->graphFactory, $this->spaceMap, $predicate, $question);

        $argumentNode = $argumentProvider->provideArgumentNode();
        
        $argument = $this->makeArgument($argumentNode);

        return $argument;
    }
    
    public function provideArgumentsByClause(INode $clauseNode)
    {
        $argumentNodes = $this->spaceMap->getArgumentNodes($clauseNode);
        
        $arguments = [];
        
        foreach ($argumentNodes as $argumentNode) {
            $arguments[] = $this->makeArgument($argumentNode);
        }
        
        return $arguments;
    }
    
    private function makeArgument($argumentNode)
    {
        return new Argument($this->clauseFactory, $this->predecateFactory, $this->questionFactory, $this->complimentFactory, $argumentNode);
    }
}