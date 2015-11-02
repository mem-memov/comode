<?php
namespace Comode\syntax;

use Comode\graph\INode;

interface IQuestionFactory
{
    public function provideQuestion($string);
    public function provideQuestionsByPredicate(node\IPredicate $predicateNode);
}