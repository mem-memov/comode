<?php
namespace Comode\syntax;

interface IFactory
{
    public function providePredicate($verb);
    public function provideQuestion($question);
    public function provideArgument(IPredicate $predicate, IQiestion $question);
    public function provideStringAnswer($phrase);
    public function provideFileAnswer($path);
    public function provideCompliment(IArgument $argument, IAnswer $answer);
    public function createClause(array $compliments);
}