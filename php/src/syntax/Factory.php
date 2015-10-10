<?php
namespace Comode\syntax;

use Comode\graph\IFactory as IGraphFactory;

class Factory implements IFactory
{
    private $statementFactory;
    
    public function __construct(IGraphFactory $graphFactory)
    {
        $questionFactory = new QuestionFactory($graphFactory);
        $answerFactory = new AnswerFactory($graphFactory);
        $factFactory = new FactFactory($graphFactory, $questionFactory, $answerFactory);
        $this->statementFactory = new StatementFactory($graphFactory, $factFactory);
    }
    
    public function createStatement()
    {
        $statement = $this->statementFactory->createStatement();
        
        return $statement;
    }
}