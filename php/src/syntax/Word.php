<?php
namespace Comode\syntax;

final class Word implements IWord
{
    private $predicateFactory;
    private $questionFactory;
    private $answerFactory;
    private $node;

    public function __construct(
        IPredicateFactory $predicateFactory,
        IQuestionFactory $questionFactory,
        IAnswerFactory $answerFactory,
        node\IWord $node
    ) {
        $this->predicateFactory = $predicateFactory;
        $this->questionFactory = $questionFactory;
        $this->answerFactory = $answerFactory;
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
    
    public function providePredicate()
    {
        return $this->predicateFactory->providePredicateByWord($this->node);
    }
    
    public function provideQuestion()
    {
         return $this->questionFactory->provideQuestionByWord($this->node);
    }
    
    public function provideAnswer()
    {
         return $this->answerFactory->provideAnswerByWord($this->node);
    }
}