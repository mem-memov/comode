<?php
namespace Comode\graph\store\fileSystem;

class Wrapper implements IWrapper
{
    public function makeDirectory($path)
    {
        mkdir($this->path, 0777, true);
    }
    
    public function fileExists($path)
    {
        return file_exists($path);
    }
    
    public function writeFile($path, $content)
    {
        file_put_contents($path, $content);
    }
    
    public function readFile($path)
    {
        return file_get_contents($path);
    }
    
    public function makeLink($targetPath, $linkPath)
    {
        symlink($targetPath, $linkPath);
    }
    
    public function deleteLink($linkPath)
    {
        unlink($linkPath);
    }
}