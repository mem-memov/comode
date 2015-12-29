<?php
namespace Comode\syntax\node;

interface ITypeChecker
{
    public function addType(INode $node, $type);
    public function removeType(INode $node, $type);
    public function ofType(INode $node, $type);
}