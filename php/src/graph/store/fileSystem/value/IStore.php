<?php
namespace Comode\graph\store\fileSystem\value;

use Comode\graph\store\fileSystem\directory\IDirectory;
use Comode\graph\store\IValue as IStoreValue;

interface IStore
{
    private function create(IStoreValue $value);
    public function bindNode($valueHash, IDirectory $nodeDirectory);
    public function getNode(IStoreValue $value);
}