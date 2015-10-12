<?php
namespace Comode\graph;
class ValueTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->path = __DIR__ . '/../../../data/tmp/test_' . time() . '_' . rand(1,10000);

        $config = [
            'store' => [
                'type' => 'fileSystem',
                'path' => $this->path
            ]
        ];
        
        $this->factory = new Factory($config);

        $this->originFilePath = $this->path . '/myTestFile.txt';
        $this->originFileContent = 'some file content';
        file_put_contents($this->originFilePath, $this->originFileContent);
    }
    
    protected function tearDown()
    {
        $this->removeDirectory($this->path);
    }
    
    protected function removeDirectory($dir)
    {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            if (is_dir($path) && !is_link($path)) {
                $this->removeDirectory($path);
            } else {
                unlink($path);
            }
        }
        return rmdir($dir);
    }
    
    public function testItProvidesItsNode()
    {
        // string value
        $stringContent = 'some text';
        
        $stringNode = $this->factory->createStringNode($stringContent);

        $stringValue = $this->factory->makeStringValue($stringContent);
        
        $valueNode = $stringValue->getNode();
        
        $this->assertEquals($stringNode->getId(), $valueNode->getId());

        // file value
        $fileNode = $this->factory->createFileNode($this->originFilePath);
        
        $fileValue = $this->factory->makeFileValue($this->originFilePath);
        
        $valueNode = $fileValue->getNode();
        
        $this->assertEquals($fileNode->getId(), $valueNode->getId());
    }
}