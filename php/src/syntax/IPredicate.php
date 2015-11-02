<?php
namespace Comode\syntax;

use Comode\graph\INode;

interface IPredicate
{
   public function addClause(INode $clauseNode);
   public function provideArgument(operation\IArgumentNodeProvider $argumentNodeProvider);
}