<?php
namespace Comode\graph\store\fileSystem\directory;

interface IFactory
{
    public function directory($path);
    public function link($path);
    public function file($path);
}