<?php
class NodeFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $store;
    protected $valueFactory;
    
    protected function setUp()
    {
        $this->store = $this->getMockBuilder('Comode\graph\store\IStore')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->valueFactory = $this->getMockBuilder('Comode\graph\IValueFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItGetsValueFactory()
    {
        $nodeFactory = new Comode\graph\NodeFactory($this->store);
        $nodeFactory->setValueFactory($this->valueFactory);
    }
    
    public function testItCreatesANewNodeWithNoValue()
    {
        $nodeFactory = new Comode\graph\NodeFactory($this->store);
        $nodeFactory->setValueFactory($this->valueFactory);
        
        $factoryNode = $nodeFactory->createNode();
        
        $this->assertInstanceOf('Comode\graph\INode', $factoryNode);
    }
    
    public function testItCreatesANewNodeWithAStringValue()
    {
        $nodeFactory = new Comode\graph\NodeFactory($this->store);
        $nodeFactory->setValueFactory($this->valueFactory);
        
        $string = 'rabbit';
        
        $factoryNode = $nodeFactory->createStringNode($string);
        
        $this->assertInstanceOf('Comode\graph\INode', $factoryNode);
    }
    
    public function testItCreatesANewNodeWithAFileValue()
    {
        $nodeFactory = new Comode\graph\NodeFactory($this->store);
        $nodeFactory->setValueFactory($this->valueFactory);
        
        $path = '/tmp/some.file';
        
        $factoryNode = $nodeFactory->createFileNode($path);
        
        $this->assertInstanceOf('Comode\graph\INode', $factoryNode);
    }
    
    public function testItRetrievesANodeByItsId()
    {
        $nodeFactory = new Comode\graph\NodeFactory($this->store);
        $nodeFactory->setValueFactory($this->valueFactory);
        
        $nodeId = 1000;

        $this->store->expects($this->any())
                    ->method('nodeExists')
                    ->willReturn(true);
        
        $factoryNode = $nodeFactory->readNode($nodeId);
        
        $this->assertInstanceOf('Comode\graph\INode', $factoryNode);
    }
    
    public function testItCreatesNewInstancesOfTheSameNode()
    {
        $nodeFactory = new Comode\graph\NodeFactory($this->store);
        $nodeFactory->setValueFactory($this->valueFactory);
        
        $nodeId = 1000;
        
        $this->store->expects($this->any())
                    ->method('nodeExists')
                    ->willReturn(true);
        
        $factoryNode_1 = $nodeFactory->readNode($nodeId);
        $factoryNode_2 = $nodeFactory->readNode($nodeId);
        
        $this->assertFalse($factoryNode_1 === $factoryNode_2);
    }
}