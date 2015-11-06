<?php
namespace Comode\syntax;

interface ICompliment
{
    public function getId();
    public function addClause(node\IClause $clauseNode);
    public function fetchClauses();
    public function provideArgument();
    public function provideAnswer();
}