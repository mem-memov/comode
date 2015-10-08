<?php
namespace Comode\graph;
class FactoryTest extends \PHPUnit_Framework_TestCase
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

    public function testItCreatesANewNodeWithNoValue()
    {
        $node = $this->factory->createNode();
        $this->assertInstanceOf('Comode\graph\INode', $node);
    }
    
    public function testItCreatesANewNodeWithAStringValue()
    {
        $node = $this->factory->createStringNode('some text');
        $this->assertInstanceOf('Comode\graph\INode', $node);
    }
    
    public function testItCreatesANewNodeWithAFileValue()
    {
        $filePath = $this->path . '/myTestFile.txt';
        file_put_contents($filePath, 'some file content');
        
        $node = $this->factory->createFileNode($filePath);
        $this->assertInstanceOf('Comode\graph\INode', $node);
    }
    
    public function testItRetrievesANodeByItsId()
    {
        $createdNode = $this->factory->createNode();
        $createdNodeId = $createdNode->getId();
        
        $retreivedNode = $this->factory->readNode($createdNodeId);
        $retreivedNodeId = $retreivedNode->getId();
        
        $this->assertEquals($createdNodeId, $retreivedNodeId);
    }
    
    public function testItCreatesNewInstancesOfTheSameNode()
    {
        $createdNode = $this->factory->createNode();
        $createdNodeId = $createdNode->getId();
        
        $retreivedNode_1 = $this->factory->readNode($createdNodeId);
        $retreivedNode_2 = $this->factory->readNode($createdNodeId);

        
        $this->assertFalse($retreivedNode_1 === $retreivedNode_2);
    }
    
    public function testItRetrievesAStringValue()
    {
        $node = $this->factory->createStringNode('some text');
        $value = $this->factory->makeStringValue('some text');
        $this->assertInstanceOf('Comode\graph\IValue', $value);
    }
    
    public function testItCreatesNewInstancesOfTheSameStringValue()
    {
        $node = $this->factory->createStringNode('some text');
        $value_1 = $this->factory->makeStringValue('some text');
        $value_2 = $this->factory->makeStringValue('some text');
        $this->assertFalse($value_1 === $value_2);
    }
    
    public function testItRetrievesAFileValue()
    {
        $filePath = $this->path . '/myTestFile.txt';
        file_put_contents($filePath, 'some file content');
        
        $node = $this->factory->createFileNode($filePath);

        $value = $this->factory->makeFileValue($filePath);

        $this->assertInstanceOf('Comode\graph\IValue', $value);
    }
    
    public function testItCreatesNewInstancesOfTheSameFileValue()
    {
        $filePath = $this->path . '/myTestFile.txt';
        file_put_contents($filePath, 'some file content');
        
        $node = $this->factory->createFileNode($filePath);
        $value_1 = $this->factory->makeFileValue($filePath);
        $value_2 = $this->factory->makeFileValue($filePath);
        $this->assertEquals(false, $value_1 === $value_2);
    }
}