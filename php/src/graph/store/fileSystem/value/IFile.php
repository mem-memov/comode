<?php
namespace Comode\graph\store\fileSystem\value;

interface IFile
{
    public function copy($originFile, $targetDirectory);
}