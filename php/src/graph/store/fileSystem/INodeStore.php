<?php
namespace Comode\graph\store\fileSystem;

interface INodeStore
{
    public function create();
    public function directory($nodeId);
    public function bindValue($nodeId, IDirectory $valueDirectory);
    public function getValue($nodeId);
}