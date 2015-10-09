<?php
namespace Comode\syntax;

use Comode\graph\IFactory as IGraphFactory;

class FactFactory implements IFactFactory
{
    private $graphFactory;
    private $questionFactory;
    private $answerFactory;
    
    public function __construct(IGraphFactory $graphFactory, IQuestionFactory $questionFactory, IAnswerFactory $answerFactory)
    {
        $this->graphFactory = $graphFactory;
        $this->questionFactory = $questionFactory;
        $this->answerFactory = $answerFactory;
    }
    
    public function createFact()
    {
        $fact = new Fact($this->graphFactory, $this->questionFactory, $this->answerFactory);
        
        return $fact;
    }
}