<?php
namespace Comode\syntax;

use Comode\graph\INode;

interface IArgumentFactory
{
    public function provideArgument(IPredicate $predicate, IQuestion $question);
    public function provideArgumentsByClause(INode $clauseNode);
}