<?php
namespace Comode\syntax;

class Fact implements IFact
{
    private $question;
    private $answer;
    private $graphFactory;
    private $questionFactory;
    private $answerFactory;
    
    public function __construct($graphFactory, $questionFactory, $answerFactory)
    {
        $this->graphFactory = $graphFactory;
        $this->questionFactory = $questionFactory;
        $this->answerFactory = $answerFactory;
    }
    
    public function setQuestion()
    {
        $this->question = $this->questionFactory->createQuestion();
        
        return $this->question;
    }
    
    public function setStringAnswer()
    {
        $this->answer = $this->answerFactory->createStringAnswer();
        
        return $this->answer;
    }
    
    public function setFileAnswer()
    {
        $this->answer = $this->answerFactory->createFileAnswer();
        
        return $this->answer;
    }
}