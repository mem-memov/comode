<?php
namespace Comode\syntax;

interface IClause
{
    public function setPredicate($predicateString);
    public function getPredicate();
    public function addArgument($questionString);
    public function getArguments();
}