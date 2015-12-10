<?php
namespace Comode\syntax;

interface IPredicateFactory
{
    public function setArgumentFactory(IArgumentFactory $argumentFactory);
    public function providePredicate($value);
    public function providePredicatesByArgument(node\IArgument $argumentNode);
}