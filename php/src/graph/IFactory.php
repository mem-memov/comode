<?php
namespace Comode\graph;

interface IFactory
{
    public function makeNode($id = null, $isFile = null, $content = null);
    public function makeValue($isFile, $content);
}
