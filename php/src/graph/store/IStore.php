<?php
namespace Comode\graph\store;

interface IStore
{
    public function nodeExists($nodeId);
    public function createNode($value = '');
    public function linkNodes($originId, $targetId);
    public function separateNodes($originId, $targetId);
    public function isLinkedToNode($originId, $targetId);
    public function getLinkedNodes($parentId);
    public function getValueNode($value);
    public function getNodeValue($nodeId);
}
