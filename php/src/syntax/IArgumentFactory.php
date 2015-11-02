<?php
namespace Comode\syntax;

use Comode\graph\INode;

interface IArgumentFactory
{
    public function provideArgument(IPredicate $predicate, IQiestion $question);
    public function provideArgumentsByClause(INode $clauseNode);
}