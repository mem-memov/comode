<?php
namespace Comode\graph\store\fileSystem;

interface IWrapper
{
    public function makeDirectory($path);
    public function fileExists($path);
    public function writeFile($path, $content);
    public function readFile($path);
    public function makeLink($targetPath, $linkPath);
    public function deleteLink($linkPath);
}