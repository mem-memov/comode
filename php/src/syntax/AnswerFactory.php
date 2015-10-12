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
    
    public function createStringAnswer($string)
    {
        $answerNode = $this->graphFactory->createStringNode($string);

        $stringAnswer = new StringAnswer($string, $answerNode);
        
        return $stringAnswer;
    }
    
    public function createFileAnswer($path)
    {
        $answerNode = $this->graphFactory->createFileNode($path);

        $fileAnswer = new FileAnswer($path, $answerNode);
        
        return $fileAnswer;
    }
}