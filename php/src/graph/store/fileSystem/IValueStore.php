<?php
namespace Comode\graph\store\fileSystem;

interface IValueStore
{
    private function create(IStoreValue $value);
    public function bindNode($valueHash, IDirectory $nodeDirectory);
    public function getNode(IStoreValue $value);
}