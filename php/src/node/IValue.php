<?php
namespace Comode\node;

interface IValue
{
    public function getNodes();
    public function isFile();
    public function getContent();
}
