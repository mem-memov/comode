<?php
namespace Comode\graph\store;

interface IFactory
{
    public function makeFileSystem(array $options);
}