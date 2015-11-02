<?php
namespace Comode\syntax\operation;

use Comode\syntax\node\IPredicate as IPredicateNode;
use Comode\syntax\node\IQuestion as IQuestionNode;

interface IArgumentNodeProvider
{
    public function setPredicateNode(IPredicateNode $predicateNode);
    public function setQuestionNode(IQuestionNode $questionNode);
    public function provideArgumentNode();
}