<?php
namespace Comode\syntax;

interface IPredicate
{
   public function addClause(INode $clauseNode);
   public function provideArgument(IArgumentProvider $argumentProvider);
}