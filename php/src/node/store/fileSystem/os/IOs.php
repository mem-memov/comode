<?php
namespace Comode\node\store\fileSystem\os;

interface IOs
{
    public function symlink($toPath, $fromPath);
}