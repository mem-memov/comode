<?php
namespace Comode\node;

interface IFactory
{
    public function makeNode($id = null, IValue $value = null);
    public function makeValue($isFile, $content);
}
