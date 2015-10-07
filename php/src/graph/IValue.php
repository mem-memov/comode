<?php
namespace Comode\graph;

interface IValue
{
    public function getNodes();
    public function isFile();
    public function getContent();
}
