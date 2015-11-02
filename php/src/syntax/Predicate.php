<?php
namespace Comode\syntax;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

class Predicate implements IPredicate
{
    private $node;

    public function __construct(INode $node)
    {
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
    
    public function provideArgument(IArgumentProvider $argumentProvider)
    {
        $argumentProvider->setPredicateNode($this->node);
    }

}