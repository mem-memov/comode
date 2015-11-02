<?php

class DirectoryFixture
{
    private $path;
    
    public function createDirectory()
    {
        $this->path = __DIR__ . '/../../data/tmp/test_' . time() . '_' . rand(1,1000000);

        return $this->path;
    }
    
    public function removeDirectory()
    {
        if (!is_null($this->path)) {
            $this->removeRecursively($this->path);
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