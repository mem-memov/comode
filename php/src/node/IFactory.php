<?php
namespace Comode\node;

interface IFactory
{
    public function makeNode($id = null, $isFile = null, $content = null);
    public function makeValue($isFile, $content);
}
