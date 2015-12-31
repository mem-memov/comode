<?php
namespace Comode\graph\store\fileSystem\directory;

interface IFile
{
    public function path();
    public function name();
    public function read();
    public function write($string);
}