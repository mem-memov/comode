<?php
namespace Comode\syntax;

final class PredicateFactory implements IPredicateFactory
{
    private $nodeFactory;
    private $wordFactory;
    private $argumentFactory;

    public function __construct(
        node\IFactory $nodeFactory,
        IWordFactory $wordFactory
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->wordFactory = $wordFactory;
    }
    
    public function setArgumentFactory(IArgumentFactory $argumentFactory)
    {
        $this->argumentFactory = $argumentFactory;
    }
    
    public function fetchPredicate($id)
    {
        $predicateNode = $this->nodeFactory->fetchPredicateNode($id);
        return $this->makePredicate($predicateNode);
    }

    public function providePredicateByWord(node\IWord $wordNode)
    {
        $predicateNodes = $this->nodeFactory->getPredicateNodes($wordNode);
        
        $predicateNodeCount = count($predicateNodes);
        
        if ($predicateNodeCount > 1) {
            throw new exception\WordMayHaveOnePredicate($wordNode, $predicateNodeCount);
        }
        
        if ($predicateNodeCount == 0) {
            $predicateNode = $this->nodeFactory->createPredicateNode();
            $predicateNode->addNode($wordNode);
            $wordNode->addNode($predicateNode);
        } else {
            $predicateNode = $predicateNodes[0];
        }

        return $this->makePredicate($predicateNode);
    }
    
    public function providePredicatesByArgument(node\IArgument $argumentNode)
    {
        $predicateNodes = $this->nodeFactory->getPredicateNodes($argumentNode);

        $predicates = [];
        
        foreach ($predicateNodes as $predicateNode) {
            $predicates[] = $this->makePredicate($predicateNode);
        }
        
        return $predicates;
    }
    
    private function makePredicate(node\IPredicate $node)
    {
        return new Predicate(
            $this->wordFactory, 
            $this->argumentFactory, 
            $node
        );
    }
}