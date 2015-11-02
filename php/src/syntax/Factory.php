<?php
namespace Comode\syntax;

use Comode\graph\IFactory as IGraphFactory;

class Factory implements IFactory
{
    private $clauseFactory;
    
    public function __construct(array $config, IGraphFactory $graphFactory)
    {
        $spaceMap = new SpaceMap($graphFactory, $config['spaceDirectory']);

        $complimentFactory = new ComplimentFactory($graphFactory, $spaceMap);
        $questionFactory = new QuestionFactory($graphFactory, $spaceMap);
        $argumentFactory = new ArgumentFactory($graphFactory, $spaceMap, $questionFactory, $complimentFactory);
        $predicateFactory = new PredicateFactory($graphFactory, $spaceMap);
        $argumentFactory->setPredicateFactory($predicateFactory);
        $this->clauseFactory = new ClauseFactory($graphFactory, $spaceMap, $predicateFactory, $argumentFactory, $questionFactory);
        $argumentFactory->setClauseFactory($this->clauseFactory);
    }
    
    public function createClause()
    {
        $clause = $this->clauseFactory->createClause();
        
        return $clause;
    }

}