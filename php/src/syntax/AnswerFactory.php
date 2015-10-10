<?php
namespace Comode\syntax;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

class AnswerFactory implements IAnswerFactory
{
    private $graphFactory;
    
    public function __construct(IGraphFactory $graphFactory)
    {
        $this->graphFactory = $graphFactory;
    }
    
    public function createStringAnswer($string, INode $factNode)
    {
        $answerNode = $this->graphFactory->createStringNode($string);
        
        $answerNode->addNode($factNode);
        $factNode->addNode($answerNode);
        
        $stringAnswer = new StringAnswer($string, $answerNode);
        
        return $stringAnswer;
    }
    
    public function createFileAnswer($path, INode $factNode)
    {
        $answerNode = $this->graphFactory->createFileNode($path);
        
        $answerNode->addNode($factNode);
        $factNode->addNode($answerNode);
        
        $fileAnswer = new FileAnswer($path, $answerNode);
        
        return $fileAnswer;
    }
}