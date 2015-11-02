<?php
namespace Comode\syntax;

use Comode\graph\INode;

interface IArgumentFactory
{
    public function setClauseFactory(IClauseFactory $clauseFactory);
    public function setPredicateFactory(IPredicateFactory $predicateFactory);
    public function provideArgument(IPredicate $predicate, IQuestion $question);
    public function provideArgumentsByClause(node\IClause $clauseNode);
    public function getArgumentsByPredicate(node\IPredicate $predicateNode);
}