<?php
namespace Comode\syntax;

use Comode\graph\INode;

class Clause implements IClause
{
    private $predicateFactory;
    private $argumentFactory;
    private $questionFactory;
    private $node;

    public function __construct(
        IPredicateFactory $predicateFactory, 
        IArgumentFactory $argumentFactory, 
        IQuestionFactory $questionFactory,
        INode $node
    )
    {
        $this->predicateFactory = $predicateFactory;
        $this->argumentFactory = $argumentFactory;
        $this->questionFactory = $questionFactory;
        $this->node = $node;
    }
    
    public function getId()
    {
        return $this->node->getId();
    }

    public function setPredicate($predicateString)
    {
        $predicates = $this->predicateFactory->providePredicatesByClause($this->node);
        
        $predicateCount = count($predicates);
        if ($predicateCount > 0) {
            throw new exception\ClausePredicateMustBeKeptUnchanged();
        }
        
        $predicate = $this->predicateFactory->providePredicate($predicateString);
        
        $predicate->addClause($this->node);

        return $predicate;
    }
    
    public function getPredicate()
    {
        $predicates = $this->predicateFactory->providePredicatesByClause($this->node);

        $predicateCount = count($predicates);
        if ($predicateCount != 1) {
            throw new exception\ClauseMustHaveOnePredicate('Clause ' . $this->node->getId() . ' has ' . $predicateCount . ' predicates.');
        }
        
        $predicate = $predicates[0];
        
        return $predicate;
    }

    public function addArgument($questionString)
    {
        $predicate = $this->getPredicate();
        $question = $this->questionFactory->provideQuestion($questionString);
        
        $argument = $this->argumentFactory->provideArgument($predicate, $question);
        
        $argument->addClause($this->node);

        return $argument;
    }
    
    public function getArguments()
    {
        $arguments = $this->argumentFactory->provideArgumentsByClause($this->node);
        
        return $arguments;
    }

}