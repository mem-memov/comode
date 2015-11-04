<?php

class GraphFixture
{
    public function setUp()
    {
        require_once __DIR__ . '/DirectoryFixture.php';
        $this->directoryFixture = new \DirectoryFixture();
        
        $this->path = $this->directoryFixture->createDirectory();

        $config = [
            'store' => [
                'type' => 'fileSystem',
                'path' => $this->path
            ]
        ];
        
        $graphFactory = new \Comode\graph\Factory($config);
        
        return $graphFactory;
        
    }
    
    public function tearDown()
    {
        $this->directoryFixture->removeDirectories();
    }
    
    public function createFile($fileName = 'myTestFile.txt', $content = 'some file content')
    {
        $filePath = $this->path . '/' . $fileName;
        file_put_contents($filePath, $content);
        
        return $filePath;
    }
}