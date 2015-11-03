<?php
namespace Comode\syntax;

class PredicateFactory implements IPredicateFactory
{
    private $nodeFactory;
    private $clauseFactory;
    private $argumentFactory;

    public function __construct(
        node\IFactory $nodeFactory,
        IArgumentFactory $argumentFactory
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->argumentFactory = $argumentFactory;
    }
    
    public function setClauseFactory(IClauseFactory $clauseFactory)
    {
        $this->clauseFactory = $clauseFactory;
    }
    
    public function providePredicate($predicateString)
    {
        $predicateNode = $this->nodeFactory->createPredicateNode($predicateString);

        $predicate = $this->makePredicate($predicateNode);
        
        return $predicate;
    }
    
    public function providePredicatesByClause(node\IClause $clauseNode)
    {
        $predicateNodes = $this->nodeFactory->getPredicateNodes($clauseNode);

        $predicates = [];
        
        foreach ($predicateNodes as $predicateNode) {
            $predicates[] = $this->makePredicate($predicateNode);
        }
        
        return $predicates;
    }
    
    private function makePredicate(node\IPredicate $predicateNode)
    {
        return new Predicate($this->clauseFactory, $this->argumentFactory, $predicateNode);
    }
}