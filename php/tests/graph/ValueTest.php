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
    
    public function testItProvidesAllNodesThatHaveTheValue()
    {
        $stringContent = 'some text';
        
        $stringNode_1 = $this->factory->makeNode(null, false, $stringContent);
        $stringNode_2 = $this->factory->makeNode(null, false, $stringContent);
        $stringNode_3 = $this->factory->makeNode(null, false, $stringContent);

        $fileNode_1 = $this->factory->makeNode(null, true, $this->originFilePath);
        $fileNode_2 = $this->factory->makeNode(null, true, $this->originFilePath);

        $stringValue = $this->factory->makeValue(false, $stringContent);
        
        $nodes = $stringValue->getNodes();
        $this->assertCount(3, $nodes);
        $ids = [];
        foreach ($nodes as $node) {
            array_push($ids, $node->getId());
        }
        $this->assertContains(1, $ids);
        $this->assertContains(2, $ids);
        $this->assertContains(3, $ids);
        
        $fileValue = $this->factory->makeValue(false, $this->originFilePath);
        
        $nodes = $fileValue->getNodes();
        $this->assertCount(2, $nodes);
        $ids = [];
        foreach ($nodes as $node) {
            array_push($ids, $node->getId());
        }
        $this->assertContains(4, $ids);
        $this->assertContains(5, $ids);
    }
}