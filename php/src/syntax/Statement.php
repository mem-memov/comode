<?php
namespace Comode\syntax;

class Statement implements IStatement
{
    private $facts = [];
    private $factFactory;
    
    public function __construct(IFactFactory $factFactory)
    {
        $this->factFactory = $factFactory;
    }

    public function addFact()
    {
        $fact = $this->factFactory->createFact();
        array_push($this->facts, $fact);
        
        return $fact;
    }
}