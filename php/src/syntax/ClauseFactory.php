<?php
namespace Comode\syntax;

class ClauseFactory implements IClauseFactory
{
    private $nodeFactory;
    private $predicateFactory;
    private $argumentFactory;
    private $questionFactory;
    
   public function __construct(
        node\IFactory $nodeFactory,
        IPredicateFactory $predicateFactory, 
        IArgumentFactory $argumentFactory, 
        IQuestionFactory $questionFactory
    )
    {
        $this->nodeFactory = $nodeFactory;
        $this->predicateFactory = $predicateFactory;
        $this->argumentFactory = $argumentFactory;
        $this->questionFactory = $questionFactory;
    }
    
    public function createClause()
    {
        $node = $this->nodeFactory->createClauseNode();
        
        return $this->makeClause($node);
    }
    
    public function getClausesByPredicate(node\IPredicate $predicateNode)
    {
        $clauseNodes = $this->nodeFactory->getClauseNodes($predicateNode);
        
        $clauses = [];
        
        foreach ($clauseNodes as $clauseNode) {
            $clauses[] = $this->makeClause($clauseNode);
        }
        
        return $clauses;
    }
    
    private function makeClause(node\IClause $clauseNode)
    {
        return new Clause(
            $this->predicateFactory,
            $this->argumentFactory,
            $this->questionFactory,
            $clauseNode
        );
    }
}