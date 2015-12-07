<?php
namespace Comode\graph;

interface IFactory
{
    public function createNode(array $structure = []);
    public function readNode($nodeId);
    public function makeValue(array $structure);
}
