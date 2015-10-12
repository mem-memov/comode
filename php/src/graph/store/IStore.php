<?php
namespace Comode\graph\store;

interface IStore
{
    public function nodeExists($nodeId);
    public function createNode(IValue $value = null);
    public function linkNodes($originId, $targetId);
    public function getChildNodes($parentId);
    public function getValueNode(IValue $value);
    public function getNodeValue($nodeId);
    public function getValue($isFile, $content);
}
