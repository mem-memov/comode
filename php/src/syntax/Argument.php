<?php
namespace Comode\syntax;

use Comode\graph\INode;

class Argument implements IArgument
{
    private $predicateFactory;
    private $questionFactory;
    private $complimentFactory;
    private $node;

    public function __construct(
        IPredicateFactory $predicateFactory,
        IQuestionFactory $questionFactory,
        IComplimentFactory $complimentFactory, 
        INode $node
    ) {
        $this->predicateFactory = $predicateFactory;
        $this->questionFactory = $questionFactory;
        $this->complimentFactory = $complimentFactory;
        $this->node = $node;
    }
    
    public function getId()
    {
        return $this->node->getId();
    }

    public function provideCompliments()
    {
        return $this->complimentFactory->provideComplimentByArgument($this->node);
    }
    
    public function provideQuestion()
    {
        $questions = $this->questionFactory->provideQuestionsByArgument($this->node);
        
        $count = count($questions);
        
        if ($count != 1) {
            throw new exception\PredicateAndQuestionHaveOneCommonArgument('Argument ' . $this->node->getId() . ' has ' . $count . ' questions.');
        }
        
        return $questions[0];
    }
    
    public function providePredicate()
    {
        $predicates = $this->predicateFactory->provideQuestionsByArgument($this->node);
        
        $count = count($predicates);
        
        if ($count != 1) {
            throw new exception\PredicateAndQuestionHaveOneCommonArgument('Argument ' . $this->node->getId() . ' has ' . $count . ' predicates.');
        }
        
        return $predicates[0];
    }
}