<?php
namespace Comode\syntax;

interface IFactory
{
    public function providePredicate(array $structure);
    public function provideQuestion(array $structure);
    public function provideArgument(IPredicate $predicate, IQuestion $question);
    public function provideAnswer(array $structure);
    public function provideCompliment(IArgument $argument, IAnswer $answer);
    public function createClause(array $compliments);
}