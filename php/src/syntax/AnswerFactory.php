<?php
namespace Comode\syntax;

use Comode\graph\IFactory as IGraphFactory;

class AnswerFactory implements IAnswerFactory
{
    private $graphFactory;
    
    public function __construct(IGraphFactory $graphFactory)
    {
        $this->graphFactory = $graphFactory;
    }
    
    public function createStringAnswer()
    {
        $stringAnswer = new StringAnswer();
        
        return $stringAnswer;
    }
    
    public function createFileAnswer()
    {
        $fileAnswer = new FileAnswer();
        
        return $fileAnswer;
    }
}