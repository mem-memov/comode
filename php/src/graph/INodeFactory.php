<?php
namespace Comode\graph;

interface INodeFactory
{
    public function setValueFactory(IValueFactory $valueFactory);
    public function createNode(array $structure = []);
    public function readNode($nodeId);
}