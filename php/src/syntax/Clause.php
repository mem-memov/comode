<?php
namespace Comode\syntax;

class Clause implements IClause
{
    private $complimentFactory;
    private $node;

    public function __construct(
        IComplimentFactory $complimentFactory,
        node\IClause $node
    )
    {
        $this->complimentFactory = $complimentFactory;
        $this->node = $node;
    }
    
    public function getId()
    {
        return $this->node->getId();
    }

    public function setPredicate($verb)
    {
        $predicates = $this->predicateFactory->providePredicatesByClause($this->node);
        
        $predicateCount = count($predicates);
        
        if ($predicateCount == 0) {
            
            $predicate = $this->predicateFactory->providePredicate($verb);
            $predicate->addToClause($this->node);
            
        } elseif ($predicateCount == 1) {
            
            $oldPredicate = $predicates[0];
            $oldPredicate->removeFromClause($this->node);
            
            $predicate = $this->predicateFactory->providePredicate($verb);
            $predicate->addToClause($this->node);
            
            $compliments = $this->complimentFactory->provideComplimentsByClause($this->node);
            foreach ($compliments as $compliment) {
                
            }
            
        } else {
            throw new exception\ClauseMustHaveOnePredicate();
        }
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
    
    public function addStringCompliment($question, $string)
    {
        $argument = $this->provideArgument($question);

        $compliment = $this->complimentFactory->provideStringCompliment($argument, $string);
        
        $compliment->addClause($this->node);
        
        return $compliment;
    }

    public function addFileCompliment($question, $path)
    {
        $argument = $this->provideArgument($question);

        $compliment = $this->complimentFactory->provideFileCompliment($argument, $path);
        
        $compliment->addClause($this->node);
        
        return $compliment;
    }

    public function getCompliments()
    {
        $arguments = $this->complimentFactory->provideComplimentsByClause($this->node);
        
        return $arguments;
    }
    
    private function provideArgument($questionString)
    {
        $predicate = $this->getPredicate();

        $argument = $this->argumentFactory->provideArgument($predicate, $questionString);
        
        return $argument;
    }

}