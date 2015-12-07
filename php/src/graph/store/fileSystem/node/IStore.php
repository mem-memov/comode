<?php
namespace Comode\graph\store\fileSystem\node;

use Comode\graph\store\fileSystem\directory\IDirectory;

interface IStore
{
    public function create();
    public function directory($nodeId);
    public function bindValue($nodeId, IDirectory $valueDirectory);
    public function getValue($nodeId);
}