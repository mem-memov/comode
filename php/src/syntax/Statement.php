<?php
namespace Comode\syntax;

use Comode\graph\INode;

class Statement implements IStatement
{
    private $node;
    private $facts = [];
    private $factFactory;
    
    public function __construct(IFactFactory $factFactory, INode $node)
    {
        $this->factFactory = $factFactory;
        $this->node = $node;
    }

    public function addFact()
    {
        $fact = $this->factFactory->createFact($this->node);
        array_push($this->facts, $fact);
        
        return $fact;
    }
}