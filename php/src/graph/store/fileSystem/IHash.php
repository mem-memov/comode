<?php
namespace Comode\graph\store\fileSystem;

interface IHash
{
    public function file($path);
    public function string($string);
}