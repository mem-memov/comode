<?php
namespace Comode\node\store\fileSystem\os;

class Linux implements IOs
{
    public function symlink($toPath, $fromPath)
    {
        symlink($toPath, $fromPath);
    }
}