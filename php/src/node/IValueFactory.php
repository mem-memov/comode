<?php
namespace Comode\node;

interface IValueFactory
{
    public function makeValue($isFile, $content);
}