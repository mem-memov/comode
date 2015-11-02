<?php
namespace Comode\syntax;

use Comode\graph\INode;

interface IPredicateFactory
{
    public function providePredicate($predicateString);
    public function providePredicatesByClause(INode $clauseNode);
}