<?php
namespace Comode\syntax;

interface IPredicateFactory
{
    public function setArgumentFactory(IArgumentFactory $argumentFactory);
    public function fetchPredicate($id);
    public function providePredicateByWord(node\IWord $wordNode);
    public function providePredicatesByArgument(node\IArgument $argumentNode);
}