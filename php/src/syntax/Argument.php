<?php
namespace Comode\syntax;

use Comode\graph\INode;

final class Argument implements IArgument
{
    private $predicateFactory;
    private $questionFactory;
    private $complimentFactory;
    private $node;

    public function __construct(
        IPredicateFactory $predicateFactory,
        IQuestionFactory $questionFactory,
        IComplimentFactory $complimentFactory, 
        node\IArgument $node
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
    
    public function addCompliment(node\ICompliment $complimentNode)
    {
        $complimentNode->addNode($this->node);
        $this->node->addNode($complimentNode);
    }

    public function provideCompliments()
    {
        return $this->complimentFactory->provideComplimentsByArgument($this->node);
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
        $predicates = $this->predicateFactory->providePredicatesByArgument($this->node);
        
        $count = count($predicates);
        
        if ($count != 1) {
            throw new exception\PredicateAndQuestionHaveOneCommonArgument('Argument ' . $this->node->getId() . ' has ' . $count . ' predicates.');
        }
        
        return $predicates[0];
    }
    
    public function provideComplimentByAnswer(IAnswer $answer)
    {
        $compliments = $this->provideCompliments();

        foreach ($compliments as $compliment) {
            $complimentAnswer = $compliment->provideAnswer();
            if ($complimentAnswer->getId() == $answer->getId()) {
                return $compliment;
            }
        }
        
        throw new exception\ArgumentAndAnswerHaveOneCommonCompliment();
    }
}