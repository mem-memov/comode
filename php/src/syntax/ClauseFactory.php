<?php
namespace Comode\syntax;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

class ClauseFactory implements IClauseFactory
{
    private $graphFactory;
    private $spaceMap;
    private $predicateFactory;
    private $argumentFactory;
    private $questionFactory;
    
   public function __construct(
        IGraphFactory $graphFactory,
        ISpaceMap $spaceMap,
        IPredicateFactory $predicateFactory, 
        IArgumentFactory $argumentFactory, 
        IQuestionFactory $questionFactory
    )
    {
        $this->graphFactory = $graphFactory;
        $this->spaceMap = $spaceMap;
        $this->predicateFactory = $predicateFactory;
        $this->argumentFactory = $argumentFactory;
        $this->questionFactory = $questionFactory;
    }
    
    public function createClause()
    {
        $node = $this->graphFactory->createNode();
        
        return $this->makeClause($node);
    }
    
    public function getClausesByPredicate(INode $predicateNode)
    {
        $clauseNodes = $this->spaceMap->getClauseNodes($predicateNode);
        
        $clauses = [];
        
        foreach ($clauseNodes as $clauseNode) {
            $clauses[] = $this->makeClause($clauseNode);
        }
        
        return $clauses;
    }
    
    private function makeClause(INode $clauseNode)
    {
        return new Clause(
            $this->predicateFactory,
            $this->argumentFactory,
            $this->questionFactory,
            $clauseNode
        );
    }
}