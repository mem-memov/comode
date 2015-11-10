<?php
namespace Comode\graph;

interface INodeFactory
{
    public function setValueFactory(IValueFactory $valueFactory);
    public function createNode();
    public function createFileNode($path);
    public function createStringNode($content);
    public function readNode($nodeId);
}