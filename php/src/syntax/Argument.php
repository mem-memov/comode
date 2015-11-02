<?php
namespace Comode\syntax;

use Comode\graph\INode;

class Argument implements IArgument
{
    private $complimentFactory;
    private $node;
    private $predicate;
    private $question;

    public function __construct(IComplimentFactory $complimentFactory, INode $node,)
    {
        $this->complimentFactory = $complimentFactory;
        $this->node = $node;
        $this->predicate = $predicate;
        $this->question = $question;
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
        $compliment = $this->complimentFactory->createStringCompliment($string);
    }
    
    public function provideFileCompliment($path)
    {
        $this->complimentFactory->createFileCompliment($path);
    }
}