<?php
namespace Comode\graph\store\fileSystem;

class NodeStoreTest extends \PHPUnit_Framework_TestCase
{
    protected $nodeRoot;
    protected $valueIndex;
    protected $id;
    
    protected function setUp()
    {
        $this->nodeRoot = $this->nodeFactory = $this->getMockBuilder('Comode\graph\store\fileSystem\directory\IDirectory')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->valueIndex = $this->nodeFactory = $this->getMockBuilder('Comode\graph\store\fileSystem\directory\IDirectory')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->id = $this->getMockBuilder('Comode\graph\store\fileSystem\IId')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItCreatesNodeDirectoryInFileSystem()
    {
        $nodeStore = new NodeStore($this->nodeRoot, $this->valueIndex, $this->id);
        
        $nodeId = 53;
        
        $this->id->expects($this->once())
                    ->method('next')
                    ->willReturn($nodeId);
                    
        $directory = $this->nodeFactory = $this->getMockBuilder('Comode\graph\store\fileSystem\directory\IDirectory')
                            ->disableOriginalConstructor()
                            ->getMock();  
                            
        $directory->expects($this->once())
                    ->method('create');
                    
        $this->nodeRoot->expects($this->once())
                    ->method('directory')
                    ->with($nodeId)
                    ->willReturn($directory);
        
        $nodeId = $nodeStore->create();
    }
    
    public function testItCreatesNodeDirectory()
    {
        $nodeStore = new NodeStore($this->nodeRoot, $this->valueIndex, $this->id);
        
        $nodeId = 53;
        
        $directory = $this->getMockBuilder('Comode\graph\store\fileSystem\directory\IDirectory')
                            ->disableOriginalConstructor()
                            ->getMock(); 
        
        $this->nodeRoot->expects($this->once())
                    ->method('directory')
                    ->with($nodeId)
                    ->willReturn($directory);
        
        $nodeStoreDirectory = $nodeStore->directory($nodeId);
        
        $this->assertSame($nodeStoreDirectory, $directory);
    }
    
    public function testItbindsValue()
    {
        $nodeStore = new NodeStore($this->nodeRoot, $this->valueIndex, $this->id);
        
        $nodeId = 53;
        
        $valueDirectory = $this->getMockBuilder('Comode\graph\store\fileSystem\directory\IDirectory')
                            ->disableOriginalConstructor()
                            ->getMock(); 
        
        $nodeStore->bindValue($nodeId, $valueDirectory);
    }
}