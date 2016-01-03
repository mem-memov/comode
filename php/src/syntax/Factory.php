<?php
namespace Comode\syntax;

use Comode\graph\IFactory as IGraphFactory;

abstract class Factory implements IFactory
{
    private $wordFactory;
    private $argumentFactory;
    private $complimentFactory;
    private $clauseFactory;
    
    public function __construct(
        IWordFactory $wordFactory,
        IArgumentFactory $argumentFactory,
        IComplimentFactory $complimentFactory,
        IClauseFactory $clauseFactory
    ) {
        $this->wordFactory = $wordFactory;
        $this->argumentFactory = $argumentFactory;
        $this->complimentFactory = $complimentFactory;
        $this->clauseFactory = $clauseFactory;
    }
    
    public function provideWord($value)
    {
        return $this->wordFactory->provideWord($value);
    }

    public function provideArgument(IPredicate $predicate, IQuestion $question)
    {
        return $this->argumentFactory->provideArgument($predicate, $question);
    }

    public function provideCompliment(IArgument $argument, IAnswer $answer)
    {
        return $this->complimentFactory->provideCompliment($argument, $answer);
    }
    
    public function createClause(array $compliments)
    {
        return $this->clauseFactory->createClause($compliments);
    }
    
    public function fetchClause($id)
    {
        return $this->clauseFactory->fetchClause($id);
    }

}