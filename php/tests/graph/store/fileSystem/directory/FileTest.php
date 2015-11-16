<?php
namespace Comode\graph\store\fileSystem\directory;

class FileTest extends \PHPUnit_Framework_TestCase
{
    protected $path;
    protected $fileSystem;
    protected $factory;
    
    protected function setUp()
    {
        $this->path = 'path/to/file.txt';
        
        $this->fileSystem = $this->getMockBuilder('Comode\graph\store\fileSystem\IWrapper')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->factory = $this->getMockBuilder('Comode\graph\store\fileSystem\directory\IFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItSuppliesItsPath()
    {
        $file = new File($this->path, $this->fileSystem, $this->factory);
        
        $path = $file->path();
        
        $this->assertEquals($path, $this->path);
    }
    
    public function testItSuppliesItsName()
    {
        $file = new File($this->path, $this->fileSystem, $this->factory);
        
        $name = 'file.txt';
        
        $this->fileSystem->expects($this->once())
                        ->method('name')
                        ->with($this->path)
                        ->willReturn($name);
        
        $fileName = $file->name();
        
        $this->assertEquals($fileName, $name);
    }
    
    public function testItProvidesFileContent()
    {
        $file = new File($this->path, $this->fileSystem, $this->factory);
        
        $content = 'bla bla bla';
        
        $this->fileSystem->expects($this->once())
                        ->method('readFile')
                        ->with($this->path)
                        ->willReturn($content);
        
        $fileContent = $file->read();
        
        $this->assertEquals($fileContent, $content);
    }
}