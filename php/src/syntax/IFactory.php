<?php
namespace Comode\syntax;

interface IFactory
{
    public function provideWord($value);
    public function fetchWord($id);
    public function fetchPredicate($id);
    public function fetchQuestion($id);
    public function fetchAnswer($id);
    public function provideArgument(IPredicate $predicate, IQuestion $question);
    public function provideCompliment(IArgument $argument, IAnswer $answer);
    public function createClause(array $compliments);
    public function fetchClause($id);
}