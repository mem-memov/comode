<?php
namespace Comode\syntax;

use Comode\graph\INode;

interface IQuestionFactory
{
    public function createQuestion($string);
}