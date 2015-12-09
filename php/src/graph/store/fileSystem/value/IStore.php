<?php
namespace Comode\graph\store\fileSystem\value;

use Comode\graph\store\fileSystem\directory\IDirectory;

interface IStore
{
    public function create($value);
    public function bindNode($valueHash, IDirectory $nodeDirectory);
    public function getNode($value);
}