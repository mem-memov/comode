<?php
namespace Comode\syntax;

use Comode\graph\IFactory as IGraphFactory;

class StatementFactory implements IStatementFactory
{
    private $graphFactory;
    private $factFactory;
    
    public function __construct(IGraphFactory $graphFactory, IFactFactory $factFactory)
    {
        $this->graphFactory = $graphFactory;
        $this->factFactory = $factFactory;
    }
    
    public function createStatement()
    {
        $statement = new Statement($this->factFactory);
        
        return $statement;
    }
}