<?php
namespace Comode\syntax;

class ArgumentFactory implements IArgumentFactory
{
    private $nodeFactory;
    private $clauseFactory;
    private $predicateFactory;
    private $questionFactory;
    private $complimentFactory;

    public function __construct(
        node\IFactory $nodeFactory,
        IQuestionFactory $questionFactory, 
        IComplimentFactory $complimentFactory
    )
    {
        $this->nodeFactory = $nodeFactory;
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
        $argumentProvider = new operation\ArgumentNodeProvider($this->nodeFactory, $predicate, $question);

        $argumentNode = $argumentProvider->provideArgumentNode();
        
        $argument = $this->makeArgument($argumentNode);

        return $argument;
    }
    
    public function provideArgumentsByClause(node\IClause $clauseNode)
    {
        $argumentNodes = $this->nodeFactory->getArgumentNodes($clauseNode);
        
        return $this->makeArguments($argumentNodes);
    }
    
    public function getArgumentsByPredicate(node\IPredicate $predicateNode)
    {
        $argumentNodes = $this->nodeFactory->getArgumentNodes($predicateNode);

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
    
    private function makeArgument(node\IArgument $argumentNode)
    {
        return new Argument($this->clauseFactory, $this->predicateFactory, $this->questionFactory, $this->complimentFactory, $argumentNode);
    }
}