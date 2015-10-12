<?php
namespace Comode\syntax;

use Comode\graph\INode;

interface IAnswerFactory
{
    public function createStringAnswer($string);
    public function createFileAnswer($path);
}