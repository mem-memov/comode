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
    
    public function createClause(array $compliments)
    {
        $node = $this->nodeFactory->createClauseNode();
        
        return $this->makeClause($node);
    }
    
    public function fetchClausesByCompliment(node\ICompliment $complimentNode)
    {
        $clauseNodes = $this->nodeFactory->getClauseNodes($complimentNode);
        
        return $this->makeClauses(array $clauseNodes);
    }

    private function makeClauses(array $clauseNodes)
    {
        $clauses = [];
        
        foreach ($clauseNodes as $clauseNode) {
            $clauses[] = $this->makeArgument($clauseNode);
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