<?php
namespace Comode\graph;

interface IFactory
{
    public function createNode();
    public function createFileNode($path);
    public function createStringNode($content);
    public function readNode($nodeId);
    public function makeStringValue($content);
    public function makeFileValue($path);
}
