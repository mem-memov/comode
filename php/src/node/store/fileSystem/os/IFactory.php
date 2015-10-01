<?php
namespace Comode\node\store\fileSystem\os;

interface IFactory
{
    public function makeWindows();
    public function makeLinux();
}