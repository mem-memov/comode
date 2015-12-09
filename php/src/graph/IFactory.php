<?php
namespace Comode\graph;

interface IFactory
{
    public function makeNode($id = null, $value = '');
}
