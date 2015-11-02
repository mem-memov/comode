<?php
namespace Comode\syntax;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

class PredicateFactory implements IPredicateFactory
{
    private $graphFactory;
    private $spaceMap;

    public function __construct(IGraphFactory $graphFactory, ISpaceMap $spaceMap)
    {
        $this->graphFactory = $graphFactory;
        $this->spaceMap = $spaceMap;
    }
    
    public function providePredicate($predicateString)
    {
        $predicateNode = $this->graphFactory->createStringNode($predicateString);

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
        return new Predicate($predicateNode);
    }
}