<?php
namespace Comode\syntax;

use Comode\graph\INode;

class FileCompliment implements ICompliment
{
    public function isFile() {
        return true;
    }
}