<?php
namespace Comode\graph\store\fileSystem\directory;

class LinkTest extends \PHPUnit_Framework_TestCase
{
    protected $path;
    protected $fileSystem;
    protected $factory;
    
    protected function setUp()
    {
        $this->path = 'path/to/link';
        
        $this->fileSystem = $this->getMockBuilder('Comode\graph\store\fileSystem\IWrapper')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->factory = $this->getMockBuilder('Comode\graph\store\fileSystem\directory\IFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItChecksPathExists()
    {
        $link = new Link($this->path, $this->fileSystem, $this->factory);
        
        $this->fileSystem->expects($this->once())
                        ->method('exists')
                        ->with($this->path)
                        ->willReturn(true);
        
        $exists = $link->exists();
        
        $this->assertTrue($exists);
    }
    
    public function testItCreatesLinkInFileSystem()
    {
        $link = new Link($this->path, $this->fileSystem, $this->factory);
        
        $targetPath = '/path/to/actual/resource';
        
        $this->fileSystem->expects($this->once())
                        ->method('makeLink')
                        ->with($targetPath, $this->path);
        
        $link->create($targetPath);
    }
    
    public function testItDeletesLink()
    {
        $link = new Link($this->path, $this->fileSystem, $this->factory);
        
        $this->fileSystem->expects($this->once())
                        ->method('deleteLink')
                        ->with($this->path);
        
        $link->delete();
    }
    
    public function testItCreatesDirectoryItPointsTo()
    {
        $link = new Link($this->path, $this->fileSystem, $this->factory);
        
        $directoryPath = 'path/to/target/directory';
        
        $this->fileSystem->expects($this->once())
                        ->method('readLink')
                        ->with($this->path)
                        ->willReturn($directoryPath);
                        
        $directory = $this->getMockBuilder('Comode\graph\store\fileSystem\directory\IDirectory')
                            ->disableOriginalConstructor()
                            ->getMock();
                        
        $this->factory->expects($this->once())
                        ->method('directory')
                        ->with($directoryPath)
                        ->willReturn($directory);
        
        $directory = $link->directory();

        $this->assertInstanceOf('Comode\graph\store\fileSystem\directory\IDirectory', $directory);
    }
}