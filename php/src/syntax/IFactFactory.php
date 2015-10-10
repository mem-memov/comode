<?php
namespace Comode\syntax;

use Comode\graph\INode;

interface IFactFactory
{
    public function createFact(INode $statementNode);
}