<?php
namespace Comode\syntax;

use Comode\graph\INode;

class StringCompliment extends Compliment
{
    public function isFile() {
        return false;
    }
}