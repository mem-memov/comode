<?php
namespace Comode\syntax;

class Predicate implements IPredicate
{
    private $argumentFactory;
    private $node;

    public function __construct(
        IArgumentFactory $argumentFactory,
        node\IPredicate $node
    ) {
        $this->argumentFactory = $argumentFactory;
        $this->node = $node;
    }
    
    public function getId()
    {
        return $this->node->getId();
    }
    
    public function getValue()
    {
        return $this->node->getValue();
    }
    
    public function addArgument(node\IArgument $argumentNode)
    {
        $argumentNode->addNode($this->node);
        $this->node->addNode($argumentNode);
    }

    public function provideArguments()
    {
        return $this->argumentFactory->provideArgumentsByPredicate($this->node);
    }

    public function provideArgumentByQuestion(IQuestion $question)
    {
        $arguments = $this->provideArguments();

        foreach ($arguments as $argument) {
            $argumentQuestion = $argument->provideQuestion();
            if ($argumentQuestion->getId() == $question->getId()) {
                return $argument;
            }
        }
        
        throw new exception\PredicateAndQuestionHaveOneCommonArgument();
    }
}