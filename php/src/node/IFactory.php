<?php
namespace Comode\node;

interface IFactory
{
    public function makeNode($id = null);
}