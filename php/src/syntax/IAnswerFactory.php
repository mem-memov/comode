<?php
namespace Comode\syntax;

use Comode\graph\INode;

interface IAnswerFactory
{
    public function createStringAnswer($string, INode $factNode);
    public function createFileAnswer($path, INode $factNode);
}