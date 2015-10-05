<?php
namespace Comode\node\store;

interface IStore
{
    public function nodeExists($nodeId);
    public function createNode(IValue $value = null);
    public function linkNodes($originId, $targetId);
    public function getChildNodes($parentId);
    public function getNodesByValue(IValue $value);
    public function getValue($nodeId);
}
