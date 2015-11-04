<?php
namespace Comode\syntax;

class ClauseFactory implements IClauseFactory
{
    private $nodeFactory;
    private $complimentFactory;

   public function __construct(
        node\IFactory $nodeFactory,
        IComplimentFactory $complimentFactory
    )
    {
        $this->nodeFactory = $nodeFactory;
        $this->complimentFactory = $complimentFactory;
    }
    
    public function createClause(array $compliments)
    {
        $clauseNode = $this->nodeFactory->createClauseNode();
        
        foreach ($compliments as $compliment) {
            $compliment->addClause($clauseNode);
        }
        
        return $this->makeClause($clauseNode);
    }
    
    public function fetchClausesByCompliment(node\ICompliment $complimentNode)
    {
        $clauseNodes = $this->nodeFactory->getClauseNodes($complimentNode);
        
        return $this->makeClauses($clauseNodes);
    }

    private function makeClauses(array $clauseNodes)
    {
        $clauses = [];
        
        foreach ($clauseNodes as $clauseNode) {
            $clauses[] = $this->makeClause($clauseNode);
        }
        
        return $clauses;
    }
    
    private function makeClause(node\IClause $clauseNode)
    {
        return new Clause(
            $this->complimentFactory,
            $clauseNode
        );
    }
}