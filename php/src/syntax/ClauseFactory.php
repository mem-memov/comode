<?php
namespace Comode\syntax;

final class ClauseFactory implements IClauseFactory
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
        
        $clause = $this->makeClause($clauseNode);
        
        foreach ($compliments as $compliment) {
            $clause->addCompliment($compliment);
        }
        
        return $clause;
    }
    
    public function fetchClause($id)
    {
        $clauseNode = $this->nodeFactory->fetchClauseNode($id);
        $clause = $this->makeClause($clauseNode);
        return $clause;
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
        $complimentSequence = $this->nodeFactory->getComplimentSequence($clauseNode);

        return new Clause(
            $this->complimentFactory,
            $complimentSequence,
            $clauseNode
        );
    }
}