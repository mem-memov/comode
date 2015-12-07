<?php
namespace Comode\graph\store\fileSystem\node;

class StoreTest extends \PHPUnit_Framework_TestCase
{
    protected $nodeRoot;
    protected $valueIndex;
    protected $id;
    protected $valueFactory;
    
    protected function setUp()
    {
        $this->nodeRoot = $this->nodeFactory = $this->getMockBuilder('Comode\graph\store\fileSystem\directory\IDirectory')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->valueIndex = $this->nodeFactory = $this->getMockBuilder('Comode\graph\store\fileSystem\directory\IDirectory')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->id = $this->getMockBuilder('Comode\graph\store\fileSystem\node\IId')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->valueFactory = $this->getMockBuilder('Comode\graph\store\value\IFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItCreatesNodeDirectoryInFileSystem()
    {
        $nodeStore = new Store($this->nodeRoot, $this->valueIndex, $this->id, $this->valueFactory);
        
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
        $nodeStore = new Store($this->nodeRoot, $this->valueIndex, $this->id, $this->valueFactory);
        
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
    
    public function testItBindsValue()
    {
        $nodeStore = new Store($this->nodeRoot, $this->valueIndex, $this->id, $this->valueFactory);
        
        $nodeId = 53;
        $valueHash = 'adefa0cfec6eaae92016e923aaba685';
        $valuePath = 'values/adefa0cfec6eaae92016e923aaba685';
        
        $valueDirectory = $this->getMockBuilder('Comode\graph\store\fileSystem\directory\IDirectory')
                            ->disableOriginalConstructor()
                            ->getMock(); 
                            
        $nodeDirectory = $this->getMockBuilder('Comode\graph\store\fileSystem\directory\IDirectory')
                            ->disableOriginalConstructor()
                            ->getMock(); 
             
        $this->valueIndex->expects($this->once())
                        ->method('directory')
                        ->with($nodeId)
                        ->willReturn($nodeDirectory);
                        
        $valueDirectory->expects($this->once())
                        ->method('name')
                        ->willReturn($valueHash);
                        
        $valueLink = $this->getMockBuilder('Comode\graph\store\fileSystem\directory\ILink')
                            ->disableOriginalConstructor()
                            ->getMock();
                        
        $nodeDirectory->expects($this->once())
                        ->method('link')
                        ->with($valueHash)
                        ->willReturn($valueLink);
                        
        $valueDirectory->expects($this->once())
                        ->method('path')
                        ->willReturn($valuePath);
                        
        $valueLink->expects($this->once())
                        ->method('create')
                        ->with($valuePath);
        
        $nodeStore->bindValue($nodeId, $valueDirectory);
    }
}