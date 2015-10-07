<?php
namespace Comode\graph\store;

interface IStore
{
    public function nodeExists($nodeId);
    public function createNode(IValue $value = null);
    public function linkNodes($originId, $targetId);
    public function getChildNodes($parentId);
    public function getNodesByValue(IValue $value);
    public function getValueByNodeId($nodeId);
    public function getValue($isFile, $content);
}
