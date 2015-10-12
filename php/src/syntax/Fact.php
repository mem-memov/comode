<?php
namespace Comode\syntax;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

class Fact implements IFact
{
    private $node;
    private $graphFactory;
    private $question;
    private $answer;
    private $questionFactory;
    private $answerFactory;
    
    public function __construct(IGraphFactory $graphFactory, IQuestionFactory $questionFactory, IAnswerFactory $answerFactory)
    {
        $this->graphFactory = $graphFactory;
        $this->questionFactory = $questionFactory;
        $this->answerFactory = $answerFactory;
    }
    
    public function setQuestion($string)
    {
        $this->question = $this->questionFactory->createQuestion($string, $this->node);
        
        return $this->question;
    }
    
    public function setStringAnswer($string)
    {
        $this->answer = $this->answerFactory->createStringAnswer($string, $this->node);
        
        $this->createNode();
        
        return $this->answer;
    }
    
    public function setFileAnswer($path)
    {
        $this->answer = $this->answerFactory->createFileAnswer($path, $this->node);
        
        $this->createNode();
        
        return $this->answer;
    }
    
    private function createNode()
    {
        if (isset($this->node)) {
            throw new exception\FactCanNotBeRedefinedAfterItsQuestionAndAnswerAreSet();
        }
        
        if (isset($this->question) && isset($this->answer)) {
            $this->node = $this->graphFactory->createNode();
        }
    }
}