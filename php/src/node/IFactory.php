<?php
namespace Comode\node;

interface IFactory {
    public function makeNode($id = null, $value = null);
    public function getChildNodes(INode $node);
    public function getNodesByValue($value);
}