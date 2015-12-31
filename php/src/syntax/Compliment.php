<?php
namespace Comode\syntax;

final class Compliment implements ICompliment
{
    private $clauseFactory;
    private $argumentFactory;
    private $answerFactory;
    private $node;
    
    public function __construct(
        IClauseFactory $clauseFactory,
        IArgumentFactory $argumentFactory,
        IAnswerFactory $answerFactory,
        node\ICompliment $node
    ) {
        $this->clauseFactory = $clauseFactory;
        $this->argumentFactory = $argumentFactory;
        $this->answerFactory = $answerFactory;
        $this->node = $node;
    }
    
    public function getId()
    {
        return $this->node->getId();
    }

    public function addClause(node\sequence\ICompliment $complimentSequence)
    {
        $complimentSequence->append($this->node);
    }
    
    public function provideNextInClause(node\sequence\ICompliment $complimentSequence, IComplimentFactory $complimentFactory)
    {
        return $complimentFactory->provideNextComplimentInClause($complimentSequence, $this->node);
    }
    
    public function providePreviousInClause(node\sequence\ICompliment $complimentSequence, IComplimentFactory $complimentFactory)
    {
        return $complimentFactory->providePreviousComplimentInClause($complimentSequence, $this->node);
    }
    
    public function fetchClauses()
    {
        return $this->clauseFactory->fetchClausesByCompliment($this->node);
    }
    
    public function provideArgument()
    {
        $arguments = $this->argumentFactory->provideArgumentsByCompliment($this->node);
        
        $count = count($arguments);
        
        if ($count != 1) {
            throw new exception\ArgumentAndAnswerHaveOneCommonCompliment('Compliment ' . $this->node->getId() . ' has ' . $count . ' arguments.');
        }
        
        return $arguments[0];
    }
    
    public function provideAnswer()
    {
        $answers = $this->answerFactory->provideAnswersByCompliment($this->node);
        
        $count = count($answers);
        
        if ($count != 1) {
            throw new exception\ArgumentAndAnswerHaveOneCommonCompliment('Compliment ' . $this->node->getId() . ' has ' . $count . ' answers.');
        }
        
        return $answers[0];
    }
}