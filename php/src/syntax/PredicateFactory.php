<?php
namespace Comode\syntax;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

class PredicateFactory implements IPredicateFactory
{
    private $graphFactory;
    private $spaceMap;
    private $clauseFactory;
    private $argumentFactory;

    public function __construct(
        IGraphFactory $graphFactory, 
        ISpaceMap $spaceMap,
        IArgumentFactory $argumentFactory
    ) {
        $this->graphFactory = $graphFactory;
        $this->spaceMap = $spaceMap;
        $this->argumentFactory = $argumentFactory;
    }
    
    public function setClauseFactory(IClauseFactory $clauseFactory)
    {
        $this->clauseFactory = $clauseFactory;
    }
    
    public function providePredicate($predicateString)
    {
        $predicateNode = $this->spaceMap->createPredicateNode($predicateString);

        $predicate = $this->makePredicate($predicateNode);
        
        return $predicate;
    }
    
    public function providePredicatesByClause(INode $clauseNode)
    {
        $predicateNodes = $this->spaceMap->getPredicateNodes($clauseNode);

        $predicates = [];
        
        foreach ($predicateNodes as $predicateNode) {
            $predicates[] = $this->makePredicate($predicateNode);
        }
        
        return $predicates;
    }
    
    private function makePredicate($predicateNode)
    {
        return new Predicate($this->clauseFactory, $this->argumentFactory, $predicateNode);
    }
}