<?php
namespace Comode\syntax;

class Compliment implements ICompliment
{
    private $clauseFactory;
    private $argumentFactory;
    private $answerFactory;
    private $node;
    
    public function __construct(
        IArgumentFactory $argumentFactory,
        IAnswerFactory $answerFactory,
        node\ICompliment $node
    ) {
        $this->argumentFactory = $argumentFactory;
        $this->answerFactory = $answerFactory;
        $this->node = $node;
    }
    
    public function setClauseFactory(IClauseFactory $clauseFactory)
    {
        $this->clauseFactory = $clauseFactory;
    }

    public function fetchClauses()
    {
        return $this->clauseFactory->fetchClausesByCompliment($this->node);
    }
}