<?php
use org\bovigo\vfs\vfsStream;

class WrapperTest extends \PHPUnit_Framework_TestCase
{
    protected $path;
    protected $root;
    
    protected function setUp()
    {
        $this->path = 'rootDirectory';
        $this->root = vfsStream::setup($this->path);
    }
    
    public function testItGetsNameFromPath()
    {
        $path = vfsStream::url($this->path);
        $wrapper = new Comode\graph\store\fileSystem\Wrapper($path);
        
        $name = $wrapper->name('path/path/path/name');
        
        $this->assertEquals($name, 'name');
    }
    
    public function testItChecksIfFileExists()
    {
        $path = vfsStream::url($this->path);
        $wrapper = new Comode\graph\store\fileSystem\Wrapper($path);

        $file = 'test.txt';
        $content = 'bla bla bla';

        vfsStream::newFile($file)
                      ->withContent($content)
                      ->at($this->root);
                      
        $fileExists = $wrapper->exists($file);
        
        $this->assertTrue($fileExists);
    }
    
    public function testItChecksIfDirectoryExists()
    {
        $path = vfsStream::url($this->path);
        $wrapper = new Comode\graph\store\fileSystem\Wrapper($path);

        $dirctory = 'my_dir';

        vfsStream::newDirectory($dirctory)
                      ->at($this->root);
                      
        $directoryPath = vfsStream::url($this->path . '/' . $directory);
                      
        $dirctoryExists = $wrapper->exists($directoryPath);
        
        $this->assertTrue($dirctoryExists);
    }
    
    public function testItMakesDirectory()
    {
        $path = vfsStream::url($this->path);
        $wrapper = new Comode\graph\store\fileSystem\Wrapper($path);

        $subdirectory = 'subdirectory';
        
        $subdirectoryPath = vfsStream::url($this->path . '/' . $subdirectory);
        
        $wrapper->makeDirectory($subdirectoryPath);
        
        $this->assertTrue($this->root->hasChild($subdirectory));
    }
    
    public function testItReadsDirectory()
    {
        $path = vfsStream::url($this->path);
        $wrapper = new Comode\graph\store\fileSystem\Wrapper($path);
        
        $subdirectory = 'subdirectory';
        
        $subdirectoryPath = vfsStream::url($this->path . '/' . $subdirectory);
        
        $structure = [
            $subdirectory => [
                'dir_1' => [],
                'dir_2' => [],
                'file_1' => 'bla bla bla'
            ]
        ];
        
        vfsStream::create($structure);
        
        $wrapperPaths = $wrapper->readDirectory($subdirectoryPath);
        
        $this->assertCount(3, $wrapperPaths);
    }
    
    public function testItMakesDirectoryWithPermission()
    {
        $path = vfsStream::url($this->path);
        $wrapper = new Comode\graph\store\fileSystem\Wrapper($path);

        $subdirectory = 'subdirectory';
        
        $subdirectoryPath = vfsStream::url($this->path . '/' . $subdirectory);
        
        $wrapper->makeDirectory($subdirectoryPath);
        
        $this->assertEquals(0777, $this->root->getChild($subdirectory)->getPermissions());
    }

    public function testItWritesFile()
    {
        $path = vfsStream::url($this->path);
        $wrapper = new Comode\graph\store\fileSystem\Wrapper($path);
        
        $file = 'test.txt';
        $content = 'bla bla bla';
        
        $filePath = vfsStream::url($this->path. '/' . $file); 
        
        $wrapper->writeFile($filePath, $content);
        
        $this->assertTrue($this->root->hasChild($file));
    }
    
    public function testItReadsFile()
    {
        $path = vfsStream::url($this->path);
        $wrapper = new Comode\graph\store\fileSystem\Wrapper($path);

        $file = 'test.txt';
        $content = 'bla bla bla';

        vfsStream::newFile($file)
                      ->withContent($content)
                      ->at($this->root);
                      
        $fileContent = $wrapper->readFile($file);
        
        $this->assertEquals($content, $fileContent);
    }
    
    public function testItCopiesFile()
    {
        $path = vfsStream::url($this->path);
        $wrapper = new Comode\graph\store\fileSystem\Wrapper($path);
        
        $structure = [
            'dir_1' => [
                'file_1' => 'bla bla bla'
            ]
        ];
        
        vfsStream::create($structure);
        
        $originPath = vfsStream::url($this->path. '/dir_1/file_1'); 
        $targetPath = vfsStream::url($this->path. '/file_1'); 
        
        $wrapper->copyFile($originPath, $targetPath);
        
        $this->assertTrue($this->root->hasChild('file_1'));
    }
    
    public function testItMakesLink()
    {
        $this->markTestSkipped('Links are currently not supported by vfsStream.');
    }
    
    public function testItReadsLink()
    {
        $this->markTestSkipped('Links are currently not supported by vfsStream.');
    }
    
    public function testItDeletesLink()
    {
        $this->markTestSkipped('Links are currently not supported by vfsStream.');
    }
}