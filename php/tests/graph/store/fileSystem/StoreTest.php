<?php
class StoreTest extends \PHPUnit_Framework_TestCase
{
/*    protected $path;
    protected $fileSystem;
    
    protected function setUp()
    {
        $this->path = 'rootDirectory';
        
        $this->fileSystem = $this->getMockBuilder('Comode\graph\store\fileSystem\IWrapper')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
                            
                            

    }
    
    public function testItCreatesMissingDirectories()
    {
        $this->fileSystem->expects($this->exactly(5))
                        ->method('fileExists')
                        ->withConsecutive(
                            [$this->path],
                            [$this->path . '/node'],
                            [$this->path . '/value'],
                            [$this->path . '/value_to_node'],
                            [$this->path . '/node_to_value']
                        )
                        ->will($this->onConsecutiveCalls(
                            false,
                            false,
                            false,
                            false,
                            false
                        ));
                        
        $this->fileSystem->expects($this->exactly(5))
                        ->method('makeDirectory')
                        ->withConsecutive(
                            [$this->path],
                            [$this->path . '/node'],
                            [$this->path . '/value'],
                            [$this->path . '/value_to_node'],
                            [$this->path . '/node_to_value']
                        );
                        
        $store = new Comode\graph\store\fileSystem\Store($this->path, $this->fileSystem);
    }
    
    public function testItChecksIfANodeExists()
    {
        $nodeId = 5;
        
        $this->fileSystem->expects($this->exactly(7)) // 2 more for this test
                        ->method('fileExists')
                       ->withConsecutive(
                            [$this->path],
                            [$this->path . '/node'],
                            [$this->path . '/value'],
                            [$this->path . '/value_to_node'],
                            [$this->path . '/node_to_value'],
                            [$this->path . '/node/' . $nodeId],
                            [$this->path . '/node/' . $nodeId]
                        )
                        ->will($this->onConsecutiveCalls(
                            true,
                            true,
                            true,
                            true,
                            true,
                            false,
                            true
                        ));

        $store = new Comode\graph\store\fileSystem\Store($this->path, $this->fileSystem);

        $this->assertFalse($store->nodeExists($nodeId));
        $this->assertTrue($store->nodeExists($nodeId));
    }
    
    public function testItCreatesNode()
    {
        
    }*/
}