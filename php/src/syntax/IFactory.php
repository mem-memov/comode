<?php
namespace Comode\syntax;

interface IFactory
{
    public function providePredicate($value);
    public function provideQuestion($value);
    public function provideArgument(IPredicate $predicate, IQuestion $question);
    public function provideAnswer($value);
    public function provideCompliment(IArgument $argument, IAnswer $answer);
    public function createClause(array $compliments);
}