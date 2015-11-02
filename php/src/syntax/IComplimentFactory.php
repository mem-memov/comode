<?php
namespace Comode\syntax;

use Comode\graph\INode;

interface IComplimentFactory
{
    public function provideStringCompliment($string);
    public function provideFileCompliment($path);
}