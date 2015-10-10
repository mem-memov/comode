<?php
namespace Comode\syntax;

use Comode\graph\INode;

class Fact implements IFact
{
    private $node;
    private $question;
    private $answer;
    private $questionFactory;
    private $answerFactory;
    
    public function __construct($questionFactory, $answerFactory, INode $node)
    {
        $this->questionFactory = $questionFactory;
        $this->answerFactory = $answerFactory;
        $this->node = $node;
    }
    
    public function setQuestion($string)
    {
        $this->question = $this->questionFactory->createQuestion($string, $this->node);
        
        return $this->question;
    }
    
    public function setStringAnswer($string)
    {
        $this->answer = $this->answerFactory->createStringAnswer($string, $this->node);
        
        return $this->answer;
    }
    
    public function setFileAnswer($path)
    {
        $this->answer = $this->answerFactory->createFileAnswer($path, $this->node);
        
        return $this->answer;
    }
}