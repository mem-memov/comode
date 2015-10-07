<?php
namespace Comode\graph;

interface IValueFactory
{
    public function makeValue($isFile, $content);
}