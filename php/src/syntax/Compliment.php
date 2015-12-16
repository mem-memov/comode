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

    public function addClause(node\IClause $clauseNode)
    {
        $clauseNode->addNode($this->node);
        $this->node->addNode($clauseNode);
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