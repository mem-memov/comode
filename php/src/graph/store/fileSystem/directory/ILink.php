<?php
namespace Comode\graph\store\fileSystem\directory;

interface ILink
{
    public function exists();
    public function create($path);
    public function delete();
    public function directory();
}