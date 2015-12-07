<?php
namespace Comode\syntax;

interface IPredicateFactory
{
    public function setArgumentFactory(IArgumentFactory $argumentFactory);
    public function providePredicate(array $structure);
    public function providePredicatesByArgument(node\IArgument $argumentNode);
}