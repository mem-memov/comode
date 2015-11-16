<?php
namespace Comode\graph\store\fileSystem\directory;

class DirectoryTest extends \PHPUnit_Framework_TestCase
{
    protected $path;
    protected $fileSystem;
    protected $factory;
    
    protected function setUp()
    {
        $this->path = 'path/to/directory';
        
        $this->fileSystem = $this->getMockBuilder('Comode\graph\store\fileSystem\IWrapper')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->factory = $this->getMockBuilder('Comode\graph\store\fileSystem\directory\IFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItSuppliesItsPath()
    {
        $directory = new Directory($this->path, $this->fileSystem, $this->factory);
        
        $path = $directory->path();
        
        $this->assertEquals($path, $this->path);
    }
    
    public function testItChecksPathExists()
    {
        $directory = new Directory($this->path, $this->fileSystem, $this->factory);
        
        $this->fileSystem->expects($this->once())
                        ->method('exists')
                        ->with($this->path)
                        ->willReturn(true);
        
        $exists = $directory->exists();
        
        $this->assertTrue($exists);
    }
    
    public function testItCreatesDirectoryInFileSystem()
    {
        $directory = new Directory($this->path, $this->fileSystem, $this->factory);

        $this->fileSystem->expects($this->once())
                        ->method('makeDirectory')
                        ->with($this->path);
        
        $directory->create();
    }
    
    public function testItSuppliesPathsOfChildItems()
    {
        $directory = new Directory($this->path, $this->fileSystem, $this->factory);
        
        $directoryPaths = $directory->paths();
        
        //$this->assert
    }
}