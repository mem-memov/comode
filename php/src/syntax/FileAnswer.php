<?php
namespace Comode\syntax;

use Comode\graph\INode;

class FileAnswer implements IAnswer
{
    private $node;
    private $path;
    
    public function __construct($path, INode $node)
    {
        $this->path = $path;
        $this->node = $node;
    }
    
    public function bindAnswerToQuestion(operation\BindAnswerToQuestion $operation)
    {
        $operation->setAnswerNode($this->node);
    }
}