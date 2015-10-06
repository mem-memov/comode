<?php
namespace Comode\node;

interface INodeFactory
{
    public function makeNode($id = null, $isFile = null, $content = null);
}