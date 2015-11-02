<?php
namespace Comode\syntax;

interface IClauseFactory
{
    public function createClause();
    public function getClausesByPredicate(node\IPredicate $predicateNode);
}