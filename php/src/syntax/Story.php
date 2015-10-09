<?php
namespace Comode\syntax;

class Story implements IStory
{
    private $statements = [];
    private $statementFactory;

    public function __construct(IStatementFactory $statementFactory)
    {
        $this->statementFactory = $statementFactory;
    }

    public function addStatement()
    {
        $statement = $this->statementFactory->createStatement();
        array_push($this->statements, $statement);
        
        return $statement;
    }
}