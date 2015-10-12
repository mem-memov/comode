<?php
namespace Comode\syntax\operation;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;
use Comode\syntax\exception\AnswerAndQuestionCanNotBeConnectedByMultipleFacts;
use Comode\syntax\IAnswer;
use Comode\syntax\IQuestion;

class BindAnswerToQuestion implements IBindAnswerToQuestion
{
    private $graphFactory;
    private $answer;
    private $question;
    private $statementNode;
    private $answerNode;
    private $questionNode;
    private $factNode;
    
    public function __construct(IGraphFactory $graphFactory, IAnswer $answer, IQuestion $question, INode $statementNode)
    {
        $this->graphFactory = $graphFactory;
        $this->answer = $answer;
        $this->question = $question;
        $this->statementNode = $statementNode;
    }
    
    public function setAnswerNode(INode $answerNode)
    {
        $this->answerNode = $answerNode;
    }
    
    public function setQuestionNode(INode $questionNode)
    {
        $this->questionNode = $questionNode;
    }
    
    public function run()
    {
        $this->answer->bindAnswerToQuestion($this);
        $this->question->bindAnswerToQuestion($this);
        
        $commonNodes = $this->answerNode->getCommonNodes($this->questionNode);
        
        $count = count($commonNodes);
        
        if ($count > 1) {
            
            throw new AnswerAndQuestionCanNotBeConnectedByMultipleFacts();
            
        } elseif ($count == 1) {
            
            $this->factNode = $commonNodes[0];
            
        } elseif ($count == 0) {
            
            $this->factNode = $this->graphFactory->createNode();
            
            $this->statementNode->addNode($this->factNode);
            $this->factNode->addNode($this->statementNode);
            
            $this->answerNode->addNode($this->factNode);
            $this->factNode->addNode($this->answerNode);
            
            $this->questionNode->addNode($this->factNode);
            $this->factNode->addNode($this->questionNode);
            
        }
    }
    
    public function getFactNode()
    {
        return $this->factNode;
    }
}