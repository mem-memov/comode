<?php
namespace Comode\syntax;

use Comode\graph\INode;

class StringCompliment implements ICompliment
{
    private $node;

    public function __construct(INode $node)
    {
        $this->node = $node;
    }

}