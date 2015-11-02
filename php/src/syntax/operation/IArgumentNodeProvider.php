<?php
namespace Comode\syntax\operation;

use Comode\graph\INode;

interface IArgumentNodeProvider
{
    public function setPredicateNode(INode $predicateNode);
    public function setQuestionNode(INode $questionNode);
    public function provideArgumentNode();
}