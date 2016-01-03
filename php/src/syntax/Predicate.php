<?php
namespace Comode\syntax;

final class Predicate implements IPredicate
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
    
    public function provideWord()
    {
        return $this->wordFactory->provideWordByPredicate($this->node);
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