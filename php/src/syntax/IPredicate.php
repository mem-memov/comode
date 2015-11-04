<?php
namespace Comode\syntax;

interface IPredicate
{
   public function getId();
   public function getValue();
   public function addClause(node\IClause $clauseNode);
   public function getClauses();
   public function provideArgument(operation\IArgumentNodeProvider $argumentNodeProvider);
}