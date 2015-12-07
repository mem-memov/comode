<?php
namespace Comode\graph\store\fileSystem\value;

interface IHash
{
    public function file($path);
    public function string($string);
}