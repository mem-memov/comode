<?php
namespace Comode\syntax\node\type;

interface ICreator
{
    public function createNode($type, $value = null);
}