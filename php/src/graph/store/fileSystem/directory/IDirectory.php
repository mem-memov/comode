<?php
namespace Comode\graph\store\fileSystem\directory;

interface IDirectory
{
    public function path();
    public function name();
    public function exists();
    public function create();
    public function paths();
    public function names();
    public function links();
    public function files();
    public function directory($name);
    public function link($name);
    public function file($name);
}