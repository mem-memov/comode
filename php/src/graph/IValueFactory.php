<?php
namespace Comode\graph;

interface IValueFactory
{
    public function setNodeFactory(INodeFactory $nodeFactory);
    public function makeValue(array $structure);
}