<?php
namespace Comode\graph;
class ValueTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        require_once __DIR__ . '/../DirectoryFixture.php';
        $this->directoryFixture = new \DirectoryFixture();
        
        $this->path = $this->directoryFixture->createDirectory();

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
        $this->directoryFixture->removeDirectories();
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