<?php
namespace Comode\syntax;

final class WordFactory implements IWordFactory
{
    private $nodeFactory;
    private $predicateFactory;
    private $questionFactory;
    private $answerFactory;
    
    public function __construct(node\IFactory $nodeFactory) {
        $this->nodeFactory = $nodeFactory;
    }
    
    public function setPredicateFactory(IPredicateFactory $predicateFactory)
    {
        $this->predicateFactory = $predicateFactory;
    }
    
    public function setQuestionFactory(IQuestionFactory $questionFactory)
    {
        $this->questionFactory = $questionFactory;
    }
    
    public function setAnswerFactory(IAnswerFactory $answerFactory)
    {
        $this->answerFactory = $answerFactory;
    }
    
    public function provideWord($value)
    {
        $wordNode = $this->nodeFactory->createWordNode($value);

        $word = $this->makeWord($wordNode);
        
        return $word;
    }
    
    public function fetchWord($id)
    {
        $wordNode = $this->nodeFactory->fetchWordNode($id);
        return $this->makeWord($wordNode);
    }
    
    public function provideWordByPredicate(node\IPredicate $predicateNode)
    {
        $wordNodes = $this->nodeFactory->getWordNodes($predicateNode);
        
        $wordNodeCount = count($wordNodes);
        
        if ($wordNodeCount != 1) {
            throw new exception\PredicateMustHaveOneWord($predicateNode, $wordNodeCount);
        }
        
        return $this->makeWord($wordNodes[0]);
    }
    
    public function provideWordByQuestion(node\IQuestion $questionNode)
    {
        $wordNodes = $this->nodeFactory->getWordNodes($questionNode);
        
        $wordNodeCount = count($wordNodes);
        
        if ($wordNodeCount != 1) {
            throw new exception\QuestionMustHaveOneWord($questionNode, $wordNodeCount);
        }
        
        return $this->makeWord($wordNodes[0]);
    }
    
    public function provideWordByAnswer(node\IAnswer $answerNode)
    {
        $wordNodes = $this->nodeFactory->getWordNodes($answerNode);
        
        $wordNodeCount = count($wordNodes);
        
        if ($wordNodeCount != 1) {
            throw new exception\AnswerMustHaveOneWord($answerNode, $wordNodeCount);
        }
        
        return $this->makeWord($wordNodes[0]);
    }
    
    private function makeWord(node\IWord $wordNode)
    {
        return new Word(
            $this->predicateFactory, 
            $this->questionFactory, 
            $this->answerFactory, 
            $wordNode
        );
    }
}