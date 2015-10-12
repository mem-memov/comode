<?php
namespace Comode\graph;

interface IValue
{
    public function getNode();
    public function isFile();
    public function getContent();
}
