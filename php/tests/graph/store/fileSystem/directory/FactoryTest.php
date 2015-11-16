<?php
namespace Comode\graph\store\fileSystem\directory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $fileSystem;
    
    protected function setUp()
    {
        $this->fileSystem = $this->getMockBuilder('Comode\graph\store\fileSystem\IWrapper')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItCreatesDirectory()
    {
        $factory = new Factory($this->fileSystem);
        
        $directory = $factory->directory('path/to/directory');
        
        $this->assertInstanceOf('Comode\graph\store\fileSystem\directory\IDirectory', $directory);
    }
    
    public function testItCreatesFile()
    {
        $factory = new Factory($this->fileSystem);
        
        $file = $factory->file('path/to/file');
        
        $this->assertInstanceOf('Comode\graph\store\fileSystem\directory\IFile', $file);
    }
    
    public function testItCreatesLink()
    {
        $factory = new Factory($this->fileSystem);
        
        $link = $factory->link('path/to/link');
        
        $this->assertInstanceOf('Comode\graph\store\fileSystem\directory\ILink', $link);
    }
}