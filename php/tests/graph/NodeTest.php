<?php
namespace Comode\graph;
class NodeTest extends \PHPUnit_Framework_TestCase
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
        
        $factory = new Factory($config);
        
        $this->emptyNode = $factory->createNode(); // id = 1
        
        $this->stringContent = 'some text';
        $this->stringNode = $factory->createStringNode($this->stringContent); // id = 2
        
        $this->originFilePath = $this->path . '/myTestFile.txt';
        $this->originFileContent = 'some file content';
        file_put_contents($this->originFilePath, $this->originFileContent);
        
        $this->fileNode = $factory->createFileNode($this->originFilePath); // id = 3
    }
    
    protected function tearDown()
    {
        $this->directoryFixture->removeDirectory();
    }

    public function testItProvidesItsOwnId()
    {
        $this->assertEquals(1, $this->emptyNode->getId());
        $this->assertEquals(2, $this->stringNode->getId());
        $this->assertEquals(3, $this->fileNode->getId());
    }
    
    public function testItsIdIsAnInteger()
    {
        $this->assertTrue(is_int($this->emptyNode->getId()));
        $this->assertTrue(is_int($this->stringNode->getId()));
        $this->assertTrue(is_int($this->fileNode->getId()));
    }
    
    public function testItCanBeConnectedToOtherNodes()
    {
        $this->emptyNode->addNode($this->stringNode);
        $this->emptyNode->addNode($this->fileNode);

        $this->stringNode->addNode($this->emptyNode);
        $this->stringNode->addNode($this->fileNode);
        
        $this->fileNode->addNode($this->emptyNode);
        $this->fileNode->addNode($this->stringNode);
    }
    
    public function testItCanBeSeparatedFromItsNode()
    {
        $this->emptyNode->addNode($this->stringNode);
        $this->emptyNode->addNode($this->fileNode);
        
        $this->emptyNode->removeNode($this->stringNode);
        $this->emptyNode->removeNode($this->stringNode);

        $this->stringNode->addNode($this->emptyNode);
        $this->stringNode->addNode($this->fileNode);
        
        $this->stringNode->removeNode($this->emptyNode);
        $this->stringNode->removeNode($this->fileNode);
        
        $this->fileNode->addNode($this->emptyNode);
        $this->fileNode->addNode($this->stringNode);
        
        $this->fileNode->removeNode($this->emptyNode);
        $this->fileNode->removeNode($this->stringNode);
    }
    
    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testItProducesAnErrorWhenYouTryToConnectItToSomethingElse()
    {
        $this->emptyNode->addNode(1);
    }
    
    public function testItProvidesAllNodesItIsConnectedTo()
    {
        // empty
        
        $this->emptyNode->addNode($this->stringNode);
        $this->emptyNode->addNode($this->fileNode);
        
        $nodes = $this->emptyNode->getNodes();
        $this->assertCount(2, $nodes);
        $ids = [];
        foreach ($nodes as $node) {
            array_push($ids, $node->getId());
        }
        $this->assertContains(2, $ids);
        $this->assertContains(3, $ids);
        
        // string
        
        $this->stringNode->addNode($this->emptyNode);
        $this->stringNode->addNode($this->fileNode);
        
        $nodes = $this->stringNode->getNodes();
        $this->assertCount(2, $nodes);
        $ids = [];
        foreach ($nodes as $node) {
            array_push($ids, $node->getId());
        }
        $this->assertContains(1, $ids);
        $this->assertContains(3, $ids);
        
        // file
        
        $this->fileNode->addNode($this->emptyNode);
        $this->fileNode->addNode($this->stringNode);
        
        $nodes = $this->fileNode->getNodes();
        $this->assertCount(2, $nodes);
        $ids = [];
        foreach ($nodes as $node) {
            array_push($ids, $node->getId());
        }
        $this->assertContains(1, $ids);
        $this->assertContains(2, $ids);
    }
    
    public function testProvidedNodesAreOfTheNodeType()
    {
        // empty
        
        $this->emptyNode->addNode($this->stringNode);
        $this->emptyNode->addNode($this->fileNode);
        
        $nodes = $this->emptyNode->getNodes();
        $this->assertContainsOnlyInstancesOf('Comode\graph\INode', $nodes);
        
        // string
        
        $this->stringNode->addNode($this->emptyNode);
        $this->stringNode->addNode($this->fileNode);
        
        $nodes = $this->stringNode->getNodes();
        $this->assertContainsOnlyInstancesOf('Comode\graph\INode', $nodes);
        
        // file
        
        $this->fileNode->addNode($this->emptyNode);
        $this->fileNode->addNode($this->stringNode);
        
        $nodes = $this->fileNode->getNodes();
        $this->assertContainsOnlyInstancesOf('Comode\graph\INode', $nodes);
    }
    
    public function testItProvidesItsValue()
    {
        $stringValue = $this->stringNode->getValue();
        $this->assertEquals($stringValue->getContent(), $this->stringContent);
        
        $fileValue = $this->fileNode->getValue();
        $fileContent = file_get_contents($fileValue->getContent());
        $this->assertEquals($fileContent, $this->originFileContent);
    }
    
    /**
     * @expectedException Comode\graph\store\ValueNotFound
     */
    public function testItDoesNotProvideAValueWhenItIsEmpty()
    {
        $this->emptyNode->getValue();
    }
    
    public function testItCopiesItsValueFileToAnInternalLocation()
    {
        $targetPath = $this->fileNode->getValue()->getContent();
        $this->assertFalse($targetPath == $this->originFilePath);
    }
}