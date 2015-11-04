<?php

class DirectoryFixture
{
    private $paths = [];
    
    public function createDirectory()
    {
        $path = __DIR__ . '/../../data/tmp/test_' . time() . '_' . rand(1,1000000);
        //mkdir($path);
        $this->paths[] = $path;

        return $path;
    }
    
    public function removeDirectories()
    {
        foreach ($this->paths as $path) {
            if (is_dir($path) && !is_link($path)) {
                $this->removeRecursively($path);
            }
        }
    }
    
    protected function removeRecursively($dir)
    {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            if (is_dir($path) && !is_link($path)) {
                $this->removeRecursively($path);
            } else {
                unlink($path);
            }
        }
        return rmdir($dir);
    }
}