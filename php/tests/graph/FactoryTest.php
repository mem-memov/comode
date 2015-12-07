<?php
namespace Comode\graph;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $nodeFactory;
    protected $valueFactory;
    protected $configuration;
    
    protected function setUp()
    {
        $this->nodeFactory = $this->getMockBuilder('Comode\graph\INodeFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
                
        $this->valueFactory = $this->getMockBuilder('Comode\graph\IValueFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
    }

    public function testItCreatesANewNodeWithNoValue()
    {
        $factory = new Factory($this->nodeFactory, $this->valueFactory);
        
        $node = $this->getMockBuilder('Comode\graph\INode')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->nodeFactory->expects($this->once())
                            ->method('createNode')
                            ->willReturn($node);
        
        $factoryNode = $factory->createNode();
        
        $this->assertEquals($factoryNode, $node);
    }
    
    public function testItCreatesANewNodeWithAValue()
    {
        $factory = new Factory($this->nodeFactory, $this->valueFactory);
        
        $node = $this->getMockBuilder('Comode\graph\INode')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $structure = ['type'=>'string', 'content'=>'rabbit'];
        
        $this->nodeFactory->expects($this->once())
                            ->method('createNode')
                            ->with($structure)
                            ->willReturn($node);
        
        $factoryNode = $factory->createNode($structure);
        
        $this->assertEquals($factoryNode, $node);
    }

    public function testItRetrievesANodeByItsId()
    {
        $factory = new Factory($this->nodeFactory, $this->valueFactory);
        
        $node = $this->getMockBuilder('Comode\graph\INode')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $nodeId = 753;
        
        $this->nodeFactory->expects($this->once())
                            ->method('readNode')
                            ->with($nodeId)
                            ->willReturn($node);
        
        $factoryNode = $factory->readNode($nodeId);
        
        $this->assertEquals($factoryNode, $node);
    }
    
    public function testItCreatesNewInstancesOfTheSameNode()
    {
        $factory = new Factory($this->nodeFactory, $this->valueFactory);
        
        $node_1 = $this->getMockBuilder('Comode\graph\INode')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $node_2 = $this->getMockBuilder('Comode\graph\INode')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->nodeFactory->expects($this->exactly(2))
                            ->method('createNode')
                            ->will($this->onConsecutiveCalls($node_1, $node_2));

        $factoryNode_1 = $factory->createNode();
        $factoryNode_2 = $factory->createNode();
        
        $this->assertFalse($factoryNode_1 === $factoryNode_2);
        
    }
    
    public function testItRetrievesAValue()
    {
        $factory = new Factory($this->nodeFactory, $this->valueFactory);
        
        $stringValue = $this->getMockBuilder('Comode\graph\IValue')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $structure = ['type'=>'string', 'content'=>'rabbit'];
        
        $this->valueFactory->expects($this->once())
                            ->method('makeValue')
                            ->with($structure)
                            ->willReturn($stringValue);
        
        $factoryStringValue = $factory->makeValue($structure);
        
        $this->assertEquals($factoryStringValue, $stringValue);
    }
    
    public function testItCreatesNewInstancesOfTheSameValue()
    {
        $factory = new Factory($this->nodeFactory, $this->valueFactory);
        
        $structure = ['type'=>'string', 'content'=>'rabbit'];
        
        $value_1 = $this->getMockBuilder('Comode\graph\IValue')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $value_2 = $this->getMockBuilder('Comode\graph\IValue')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->valueFactory->expects($this->exactly(2))
                            ->method('makeValue')
                            ->will($this->onConsecutiveCalls($value_1, $value_2));
        
        $factoryStringValue_1 = $factory->makeValue($structure);
        $factoryStringValue_2 = $factory->makeValue($structure);
        
        $this->assertFalse($factoryStringValue_1 === $factoryStringValue_2);
    }
}