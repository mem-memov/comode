<?php
namespace Comode\syntax;

class PredicateFactory implements IPredicateFactory
{
    private $nodeFactory;
    private $argumentFactory;

    public function __construct(
        node\IFactory $nodeFactory
    ) {
        $this->nodeFactory = $nodeFactory;
    }
    
    public function setArgumentFactory(IArgumentFactory $argumentFactory)
    {
        $this->argumentFactory = $argumentFactory;
    }

    public function providePredicate($value)
    {
        $node = $this->nodeFactory->createPredicateNode($value);

        return $this->makePredicate($node);
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
        return new Predicate($this->argumentFactory, $node);
    }
}