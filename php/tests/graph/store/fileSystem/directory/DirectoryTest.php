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
    
    public function testItSuppliesItsName()
    {
        $directory = new Directory($this->path, $this->fileSystem, $this->factory);
        
        $name = 'my_directory';
        
        $this->fileSystem->expects($this->once())
                        ->method('name')
                        ->with($this->path)
                        ->willReturn($name);
        
        $directoryName = $directory->name();
        
        $this->assertEquals($directoryName, $name);
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
        
        $paths = [
            $this->path.'/subdirectory/some.file',
            $this->path.'/subdirectory/another.file',
            $this->path.'/subdirectory/a_directory',
            $this->path.'/subdirectory/a_link'
        ];
        
        $this->fileSystem->expects($this->once())
                        ->method('readDirectory')
                        ->with($this->path)
                        ->willReturn($paths);
        
        $directoryPaths = $directory->paths();
        
        $this->assertEquals($directoryPaths, $paths);
    }
    
    public function testItSuppliesNamesOfChildItems()
    {
        $directory = new Directory($this->path, $this->fileSystem, $this->factory);

        $paths = [
            $this->path.'/some.file',
            $this->path.'/another.file',
            $this->path.'/a_directory',
            $this->path.'/a_link'
        ];
        
        $names = [
            'some.file',
            'another.file',
            'a_directory',
            'a_link'
        ];

        $this->fileSystem->expects($this->once())
                        ->method('readDirectory')
                        ->with($this->path)
                        ->willReturn($paths);
                        
        $this->fileSystem->expects($this->exactly(4))
                        ->method('name')
                        ->withConsecutive(
                            [$paths[0]],
                            [$paths[1]],
                            [$paths[2]],
                            [$paths[3]]
                        )
                        ->will($this->onConsecutiveCalls(
                            $names[0],
                            $names[1],
                            $names[2],
                            $names[3]
                        ));
        
        $directoryNames = $directory->names();

        $this->assertEquals($directoryNames, $names);
    }
    
    public function testItCreatesLinksWithChildItems()
    {
        $directory = new Directory($this->path, $this->fileSystem, $this->factory);
        
        $paths = [
            $this->path.'/link_1',
            $this->path.'/link_2'
        ];
        
        $this->fileSystem->expects($this->once())
                        ->method('readDirectory')
                        ->with($this->path)
                        ->willReturn($paths);
        
        $links = [
            $this->getMockBuilder('Comode\graph\store\fileSystem\directory\ILink')
                                        ->disableOriginalConstructor()
                                        ->getMock(),
            $this->getMockBuilder('Comode\graph\store\fileSystem\directory\ILink')
                                        ->disableOriginalConstructor()
                                        ->getMock()
        ];
        
        $this->factory->expects($this->exactly(2))
                        ->method('link')
                        ->withConsecutive(
                            [$paths[0]],
                            [$paths[1]]
                        )
                        ->will($this->onConsecutiveCalls(
                            $links[0],
                            $links[1]
                        ));
        
        $directoryLinks = $directory->links();
        
        $this->assertEquals($directoryLinks, $links);
    }
    
    public function testItCreatesFilesWithChildItems()
    {
        $directory = new Directory($this->path, $this->fileSystem, $this->factory);
        
        $paths = [
            $this->path.'/file_1',
            $this->path.'/file_2'
        ];
        
        $this->fileSystem->expects($this->once())
                        ->method('readDirectory')
                        ->with($this->path)
                        ->willReturn($paths);
        
        $files = [
            $this->getMockBuilder('Comode\graph\store\fileSystem\directory\IFile')
                                        ->disableOriginalConstructor()
                                        ->getMock(),
            $this->getMockBuilder('Comode\graph\store\fileSystem\directory\IFile')
                                        ->disableOriginalConstructor()
                                        ->getMock()
        ];
        
        $this->factory->expects($this->exactly(2))
                        ->method('file')
                        ->withConsecutive(
                            [$paths[0]],
                            [$paths[1]]
                        )
                        ->will($this->onConsecutiveCalls(
                            $files[0],
                            $files[1]
                        ));
        
        $directoryFiles = $directory->files();
        
        $this->assertEquals($directoryFiles, $files);
    }
    
    public function testItCreatesDirectoryWithName()
    {
        $directory = new Directory($this->path, $this->fileSystem, $this->factory);
        
        $name = 'subdirectory';
        
        $aDirectory = $this->getMockBuilder('Comode\graph\store\fileSystem\directory\IDirectory')
                                ->disableOriginalConstructor()
                                ->getMock();
        
        $this->factory->expects($this->once())
                        ->method('directory')
                        ->with($this->path . '/' . $name)
                        ->willReturn($aDirectory);
        
        $createdDirectory = $directory->directory($name);
        
        $this->assertSame($createdDirectory, $aDirectory);
    }
    
    public function testItCreatesLinkWithName()
    {
        $directory = new Directory($this->path, $this->fileSystem, $this->factory);
        
        $name = 'myLink';
        
        $link = $this->getMockBuilder('Comode\graph\store\fileSystem\directory\ILink')
                                ->disableOriginalConstructor()
                                ->getMock();
        
        $this->factory->expects($this->once())
                        ->method('link')
                        ->with($this->path . '/' . $name)
                        ->willReturn($link);
        
        $directoryLink = $directory->link($name);
        
        $this->assertSame($directoryLink, $link);
    }
    
    public function testItCreatesFilekWithName()
    {
        $directory = new Directory($this->path, $this->fileSystem, $this->factory);
        
        $name = 'myFile';
        
        $file = $this->getMockBuilder('Comode\graph\store\fileSystem\directory\IFile')
                                ->disableOriginalConstructor()
                                ->getMock();
        
        $this->factory->expects($this->once())
                        ->method('file')
                        ->with($this->path . '/' . $name)
                        ->willReturn($file);
        
        $directoryFile = $directory->file($name);
        
        $this->assertSame($directoryFile, $file);
    }
}