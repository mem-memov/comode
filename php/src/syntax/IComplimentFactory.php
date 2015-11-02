<?php
namespace Comode\syntax;

use Comode\graph\INode;

interface IComplimentFactory
{
    public function createStringCompliment($string);
    public function createFileCompliment($path);
}