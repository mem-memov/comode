<?php
namespace Comode\graph\store\fileSystem;

class Wrapper implements IWrapper
{
    public function name($path)
    {
        return basename($path);
    }
    
    public function exists($path)
    {
        return file_exists($path);
    }

    public function makeDirectory($path)
    {
        mkdir($path, 0777, true);
    }
    
    public function readDirectory($path)
    {
        return array_diff(scandir($path,  SCANDIR_SORT_NONE), ['.', '..']);
    }

    public function writeFile($path, $content)
    {
        file_put_contents($path, $content);
    }
    
    public function readFile($path)
    {
        return file_get_contents($path);
    }
    
    public function copyFile($originPath, $targetPath)
    {
        copy($originPath, $targetPath);
    }

    public function makeLink($targetPath, $linkPath)
    {
        symlink($targetPath, $linkPath);
    }
    
    public function readLink($linkPath)
    {
        return readlink($linkPath);
    }
    
    public function deleteLink($linkPath)
    {
        unlink($linkPath);
    }
}