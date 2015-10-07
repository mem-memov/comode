<?php
class FactoryTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->path = __DIR__ . '/../../../data/tmp/test_' . time() . '_' . rand(1,10000);
        
        $config = [
            'store' => [
                'type' => 'fileSystem',
                'path' => $this->path
            ]
        ];
        
        $this->factory = new Comode\graph\Factory($config);
    }
    
    protected function tearDown()
    {
        $r = $this->removeDirectory($this->path);
    }
    
    protected function removeDirectory($dir)
    {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            if (is_dir($path) && !is_link($path)) {
                $this->removeDirectory($path);
            } else {
                unlink($path);
            }
        }
        return rmdir($dir);
    }

    public function testItCreatesANewNodeWithNoValue()
    {
        $node = $this->factory->makeNode();
        $this->assertInstanceOf('Comode\graph\INode', $node);
    }
    
    public function testItRetrievesANodeByItsId()
    {
        $createdNode = $this->factory->makeNode();
        $createdNodeId = $createdNode->getId();
        
        $retreivedNode = $this->factory->makeNode($createdNodeId);
        $retreivedNodeId = $retreivedNode->getId();
        
        $this->assertEquals($createdNodeId, $retreivedNodeId);
    }
    
    public function testItCreatesNewInstancesOfTheSameNode()
    {
        $createdNode = $this->factory->makeNode();
        $createdNodeId = $createdNode->getId();
        
        $retreivedNode_1 = $this->factory->makeNode($createdNodeId);
        $retreivedNode_2 = $this->factory->makeNode($createdNodeId);

        
        $this->assertEquals(false, $retreivedNode_1 === $retreivedNode_2);
    }
}