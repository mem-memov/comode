<?php
namespace Comode\graph\store\fileSystem\value\strategy;

interface IValue
{
    public function create(IHash $hash, IDirectory $root);
}