<?php
namespace Comode\syntax;

use Comode\graph\IFactory as IGraphFactory;

class Factory implements IFactory
{
    private $clauseFactory;
    
    public function __construct(array $config, IGraphFactory $graphFactory)
    {
        $nodeFactory = new node\Factory($graphFactory, $config['spaceDirectory']);

        $complimentFactory = new ComplimentFactory($nodeFactory);
        $questionFactory = new QuestionFactory($nodeFactory);
        $argumentFactory = new ArgumentFactory($nodeFactory, $questionFactory, $complimentFactory);
        $predicateFactory = new PredicateFactory($nodeFactory, $argumentFactory);
        $argumentFactory->setPredicateFactory($predicateFactory);
        $this->clauseFactory = new ClauseFactory($nodeFactory, $predicateFactory, $argumentFactory, $questionFactory);
        $predicateFactory->setClauseFactory($this->clauseFactory);
        $argumentFactory->setClauseFactory($this->clauseFactory);
    }
    
    public function createClause()
    {
        $clause = $this->clauseFactory->createClause();
        
        return $clause;
    }

}