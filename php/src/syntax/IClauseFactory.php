<?php
namespace Comode\syntax;

interface IClauseFactory
{
    public function createClause(array $compliments);
    public function fetchClausesByCompliment(node\ICompliment $complimentNode);
}