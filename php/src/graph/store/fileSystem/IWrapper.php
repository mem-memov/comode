<?php
namespace Comode\graph\store\fileSystem;

interface IWrapper
{
    public function name($path);
    public function exists($path);

    public function makeDirectory($path);
    public function readDirectory($path);

    public function writeFile($path, $content);
    public function readFile($path);

    public function makeLink($targetPath, $linkPath);
    public function readLink($linkPath);
    public function deleteLink($linkPath);
}