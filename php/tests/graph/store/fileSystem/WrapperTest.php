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

    public function testItChecksIfFileExists()
    {
        $path = vfsStream::url($this->path);
        $wrapper = new Comode\graph\store\fileSystem\Wrapper($path);

        $file = 'test.txt';
        $content = 'bla bla bla';

        vfsStream::newFile($file)
                      ->withContent($content)
                      ->at($this->root);
                      
        $fileExists = $wrapper->fileExists($file);
        
        $this->assertTrue($fileExists);
    }
    
    public function testItWritesFile()
    {
        $path = vfsStream::url($this->path);
        $wrapper = new Comode\graph\store\fileSystem\Wrapper($path);
        
        $file = 'test.txt';
        $content = 'bla bla bla';
        
        $filePath = vfsStream::url($this->path. '/' . $file); 
        
        $wrapper->writeFile($filePath, $content);
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
    
    public function testItMakesLink()
    {
        $this->markTestSkipped('Links are currently not supported by vfsStream.');
        
        $path = vfsStream::url($this->path);
        $wrapper = new Comode\graph\store\fileSystem\Wrapper($path);

        $file = 'test.txt';
        $content = 'bla bla bla';

        vfsStream::newFile($file)
                      ->withContent($content)
                      ->at($this->root);
                      
        $link = 'testlink';
        
        //$wrapper->makeLink(vfsStream::url($this->path . $file), vfsStream::url($this->path . $link));
    }
    
    public function testItDeletesLink()
    {
        $this->markTestSkipped('Links are currently not supported by vfsStream.');
        
        $path = vfsStream::url($this->path);
        $wrapper = new Comode\graph\store\fileSystem\Wrapper($path);

        $file = 'test.txt';
        $content = 'bla bla bla';

        vfsStream::newFile($file)
                      ->withContent($content)
                      ->at($this->root);
    }
}