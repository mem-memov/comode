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
    private $statementNode;
    
    public function __construct(IGraphFactory $graphFactory, IQuestionFactory $questionFactory, IAnswerFactory $answerFactory, INode $statementNode)
    {
        $this->graphFactory = $graphFactory;
        $this->questionFactory = $questionFactory;
        $this->answerFactory = $answerFactory;
        $this->statementNode = $statementNode;
    }
    
    public function setQuestion($string)
    {
        $this->question = $this->questionFactory->createQuestion($string, $this->node);
        
        return $this->question;
    }
    
    public function setStringAnswer($string)
    {
        $this->answer = $this->answerFactory->createStringAnswer($string, $this->node);
        
        $this->setNode();
        
        return $this->answer;
    }
    
    public function setFileAnswer($path)
    {
        $this->answer = $this->answerFactory->createFileAnswer($path, $this->node);
        
        $this->setNode();
        
        return $this->answer;
    }
    
    private function setNode()
    {
        if (isset($this->node)) {
            throw new exception\FactCanNotBeRedefinedAfterItsQuestionAndAnswerAreSet();
        }
        
        if (isset($this->question) && isset($this->answer)) {
            $bindAnswerToQuestion = new operation\BindAnswerToQuestion($this->graphFactory, $this->answer, $this->question, $this->statementNode);
            $bindAnswerToQuestion->run();
            $this->node = $bindAnswerToQuestion->getFactNode();
        }
    }
}