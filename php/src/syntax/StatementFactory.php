<?php
namespace Comode\syntax;

use Comode\graph\IFactory as IGraphFactory;

class StatementFactory implements IStatementFactory
{
    private $graphFactory;
    private $factFactory;
    private $spaceMap;
    
    public function __construct(IGraphFactory $graphFactory, IFactFactory $factFactory, ISpaceMap $spaceMap)
    {
        $this->graphFactory = $graphFactory;
        $this->factFactory = $factFactory;
        $this->spaceMap = $spaceMap;
    }
    
    public function createStatement()
    {
        $node = $this->graphFactory->createNode();
        
        $statement = new Statement($this->factFactory, $node);
        
        return $statement;
    }
}