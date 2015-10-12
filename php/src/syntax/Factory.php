<?php
namespace Comode\syntax;

use Comode\graph\IFactory as IGraphFactory;

class Factory implements IFactory
{
    private $statementFactory;
    
    public function __construct(array $config, IGraphFactory $graphFactory)
    {
        $spaceMap = new SpaceMap($graphFactory, $config['spaceDirectory']);
        
        $questionFactory = new QuestionFactory($graphFactory, $spaceMap);
        $answerFactory = new AnswerFactory($graphFactory, $spaceMap);
        $factFactory = new FactFactory($graphFactory, $questionFactory, $answerFactory, $spaceMap);
        $this->statementFactory = new StatementFactory($graphFactory, $factFactory, $spaceMap);
    }
    
    public function createStatement()
    {
        $statement = $this->statementFactory->createStatement();
        
        return $statement;
    }

}