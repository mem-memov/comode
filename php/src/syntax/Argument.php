<?php
namespace Comode\syntax;

use Comode\graph\INode;

class Argument implements IArgument
{
    private $clauseFactory;
    private $predicateFactory;
    private $questionFactory;
    private $complimentFactory;
    private $node;

    public function __construct(
        IClauseFactory $clauseFactory,
        IPredicateFactory $predicateFactory,
        IQuestionFactory $questionFactory,
        IComplimentFactory $complimentFactory, 
        INode $node
    ) {
        $this->clauseFactory = $clauseFactory; 
        $this->predicateFactory = $predicateFactory;
        $this->questionFactory = $questionFactory;
        $this->complimentFactory = $complimentFactory;
        $this->node = $node;
    }
    
    public function getId()
    {
        return $this->node->getId();
    }
    
    public function addClause(node\IClause $clauseNode)
    {
        if ($this->node->hasNode($clauseNode)) {
            throw new exception\ClauseArgumentMayNotRepeat();
        }
        
        $clauseNode->addNode($this->node);
        $this->node->addNode($clauseNode);
    }
    
    public function provideStringCompliment($string)
    {
        $compliment = $this->complimentFactory->provideStringCompliment($string);
        
        if (!$compliment->hasArgument($this->node)) {
            $compliment->addArgument($this->node);
        }
    }
    
    public function provideFileCompliment($path)
    {
        $compliment = $this->complimentFactory->provideFileCompliment($path);
        
        if (!$compliment->hasArgument($this->node)) {
            $compliment->addArgument($this->node);
        }
    }
    
    public function getQuestion()
    {
        $questions = $this->questionFactory->provideQuestionsByPredicate($this->node);
        
        $questionCount = count($questions);
        
        if ($questionCount != 1) {
            throw new exception\PredicateAndQuestionHaveOneCommonArgument('Argument ' . $this->node->getId() . ' has ' . $questionCount . ' questions.');
        }
        
        return $questions[0];
    }
}