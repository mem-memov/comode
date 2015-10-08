<?php
namespace Comode\graph;

interface IValueFactory
{
    public function makeStringValue($content);
    public function makeFileValue($path);
}