<?php
namespace Comode\syntax;

final class ArgumentFactory implements IArgumentFactory
{
    private $nodeFactory;
    private $predicateFactory;
    private $questionFactory;
    private $complimentFactory;

    public function __construct(
        node\IFactory $nodeFactory,
        IPredicateFactory $predicateFactory,
        IQuestionFactory $questionFactory
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->predicateFactory = $predicateFactory;
        $this->questionFactory = $questionFactory;
    }

    public function setComplimentFactory(IComplimentFactory $complimentFactory)
    {
        $this->complimentFactory = $complimentFactory;
    }
    
    public function provideArgument(IPredicate $predicate, IQuestion $question)
    {
        try {
            
            $argument = $predicate->provideArgumentByQuestion($question);
            
        } catch (exception\PredicateAndQuestionHaveOneCommonArgument $e) {
            
            $argumentNode = $this->nodeFactory->createArgumentNode();
            $predicate->addArgument($argumentNode);
            $question->addArgument($argumentNode);
            $argument = $this->makeArgument($argumentNode);
        }

        return $argument;
    }
    
    public function provideArgumentsByQuestion(node\IQuestion $questionNode)
    {
        $argumentNodes = $this->nodeFactory->getArgumentNodes($questionNode);
        
        return $this->makeArguments($argumentNodes);
    }
    
    public function provideArgumentsByPredicate(node\IPredicate $predicateNode)
    {
        $argumentNodes = $this->nodeFactory->getArgumentNodes($predicateNode);

        return $this->makeArguments($argumentNodes);
    }
    
    public function provideArgumentsByCompliment(node\ICompliment $complimentNode)
    {
        $argumentNodes = $this->nodeFactory->getArgumentNodes($complimentNode);

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
    
    private function makeArgument(node\IArgument $node)
    {
        return new Argument($this->predicateFactory, $this->questionFactory, $this->complimentFactory, $node);
    }
}