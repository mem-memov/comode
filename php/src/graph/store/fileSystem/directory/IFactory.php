<?php
namespace Comode\graph\store\fileSystem;

interface IDirectory
{
    public function initialize();
    public function valueToNodeIndex($valueHash);
    public function nodeToValueIndex($nodeId);
}