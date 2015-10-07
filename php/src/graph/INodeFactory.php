<?php
namespace Comode\graph;

interface INodeFactory
{
    public function makeNode($id = null, $isFile = null, $content = null);
}