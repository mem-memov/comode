<?php
namespace Comode\syntax;

use Comode\graph\INode;

class Question implements IQuestion
{
    private $node;
    private $string;
    
    public function __construct($string, INode $node)
    {
        $this->string = $string;
        $this->node = $node;
    }
    
    public function bindAnswerToQuestion(operation\BindAnswerToQuestion $operation)
    {
        $operation->setQuestionNode($this->node);
    }
}