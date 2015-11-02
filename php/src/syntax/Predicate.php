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
    
    public function getId()
    {
        return $this->node->getId();
    }
    
    public function getValue()
    {
        return $this->node->getValue()->getContent();
    }
    
    public function addClause(node\IClause $clauseNode)
    {
        if ($this->node->hasNode($clauseNode)) {
            throw new exception\ClauseMustHaveOnePredicate('Predicate '. $this->node->getId . ' is already linked to clause ' . $clauseNode->getId());
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
    
    public function provideArgument(operation\IArgumentNodeProvider $argumentNodeProvider)
    {
        $argumentNodeProvider->setPredicateNode($this->node);
    }

}