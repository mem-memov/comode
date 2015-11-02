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
    
    public function addClause(INode $clauseNode)
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
}