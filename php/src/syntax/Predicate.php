<?php
namespace Comode\syntax;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

class Predicate implements IPredicate
{
    private $clauseFactory;
    private $argumentFactory;
    private $node;

    public function __construct(IClauseFactory $clauseFactory, IArgumentFactory $argumentFactory,INode $node)
    {
        $this->clauseFactory = $clauseFactory;
        $this->argumentFactory = $argumentFactory;
        $this->node = $node;
    }
    
    public function addClause(INode $clauseNode)
    {
        if ($this->node->hasNode($clauseNode)) {
            throw new exception\ClauseMustHaveOnePredicate();
        }
        
        $clauseNode->addNode($this->node);
        $this->node->addNode($clauseNode);
    }
    
    public function getClauses()
    {
        return $this->clauseFactory->getClausesByPredicate($this->node);
    }
    
    public function getArguments()
    {
        return $this->argumentFactory->getArgumentsByPredicate($this->node);
    }
    
    public function provideArgument(IArgumentProvider $argumentProvider)
    {
        $argumentProvider->setPredicateNode($this->node);
    }

}