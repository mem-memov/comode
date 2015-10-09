<?php
namespace Comode\syntax;

use Comode\graph\IFactory as IGraphFactory;

class QuestionFactory implements IQuestionFactory
{
    private $graphFactory;
    
    public function __construct(IGraphFactory $graphFactory)
    {
        $this->graphFactory = $graphFactory;
    }
    
    public function createQuestion()
    {
        $question = new Question();
        
        return $question;
    }
}