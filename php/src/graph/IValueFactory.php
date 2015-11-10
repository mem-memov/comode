<?php
namespace Comode\graph;

interface IValueFactory
{
    public function setNodeFactory(INodeFactory $nodeFactory);
    public function makeStringValue($content);
    public function makeFileValue($path);
}