<?php
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
        $factory = new Comode\graph\Factory($this->nodeFactory, $this->valueFactory);
        
        $node = $this->getMockBuilder('Comode\graph\INode')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->nodeFactory->expects($this->once())
                            ->method('createNode')
                            ->willReturn($node);
        
        $factoryNode = $factory->createNode();
        
        $this->assertEquals($factoryNode, $node);
    }
    
    public function testItCreatesANewNodeWithAStringValue()
    {
        $factory = new Comode\graph\Factory($this->nodeFactory, $this->valueFactory);
        
        $node = $this->getMockBuilder('Comode\graph\INode')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $string = 'rabbit';
        
        $this->nodeFactory->expects($this->once())
                            ->method('createStringNode')
                            ->with($string)
                            ->willReturn($node);
        
        $factoryNode = $factory->createStringNode($string);
        
        $this->assertEquals($factoryNode, $node);
    }
    
    public function testItCreatesANewNodeWithAFileValue()
    {
        $factory = new Comode\graph\Factory($this->nodeFactory, $this->valueFactory);
        
        $node = $this->getMockBuilder('Comode\graph\INode')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $path = '/tmp/some.file';
        
        $this->nodeFactory->expects($this->once())
                            ->method('createStringNode')
                            ->with($path)
                            ->willReturn($node);
        
        $factoryNode = $factory->createStringNode($path);
        
        $this->assertEquals($factoryNode, $node);
    }
    
    public function testItRetrievesANodeByItsId()
    {
        $factory = new Comode\graph\Factory($this->nodeFactory, $this->valueFactory);
        
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
        $factory = new Comode\graph\Factory($this->nodeFactory, $this->valueFactory);
        
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
    
    public function testItRetrievesAStringValue()
    {
        $factory = new Comode\graph\Factory($this->nodeFactory, $this->valueFactory);
        
        $stringValue = $this->getMockBuilder('Comode\graph\IValue')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $string = 'rabbit';
        
        $this->valueFactory->expects($this->once())
                            ->method('makeStringValue')
                            ->with($string)
                            ->willReturn($stringValue);
        
        $factoryStringValue = $factory->makeStringValue($string);
        
        $this->assertEquals($factoryStringValue, $stringValue);
    }
    
    public function testItCreatesNewInstancesOfTheSameStringValue()
    {
        $factory = new Comode\graph\Factory($this->nodeFactory, $this->valueFactory);
        
        $string = 'rabbit';
        
        $value_1 = $this->getMockBuilder('Comode\graph\IValue')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $value_2 = $this->getMockBuilder('Comode\graph\IValue')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->valueFactory->expects($this->exactly(2))
                            ->method('makeStringValue')
                            ->will($this->onConsecutiveCalls($value_1, $value_2));
        
        $factoryStringValue_1 = $factory->makeStringValue($string);
        $factoryStringValue_2 = $factory->makeStringValue($string);
        
        $this->assertFalse($factoryStringValue_1 === $factoryStringValue_2);
    }
    
    public function testItRetrievesAFileValue()
    {
        $factory = new Comode\graph\Factory($this->nodeFactory, $this->valueFactory);
        
        $fileValue = $this->getMockBuilder('Comode\graph\IValue')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $path = '/tmp/some.file';
        
        $this->valueFactory->expects($this->once())
                            ->method('makeFileValue')
                            ->with($path)
                            ->willReturn($fileValue);
        
        $factoryFileValue = $factory->makeFileValue($path);
        
        $this->assertEquals($factoryStringValue, $stringValue);
    }
    
    public function testItCreatesNewInstancesOfTheSameFileValue()
    {
        $factory = new Comode\graph\Factory($this->nodeFactory, $this->valueFactory);
        
        $path = '/tmp/some.file';
        
        $value_1 = $this->getMockBuilder('Comode\graph\IValue')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $value_2 = $this->getMockBuilder('Comode\graph\IValue')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->valueFactory->expects($this->exactly(2))
                            ->method('makeStringValue')
                            ->will($this->onConsecutiveCalls($value_1, $value_2));
        
        $factoryStringValue_1 = $factory->makeStringValue($path);
        $factoryStringValue_2 = $factory->makeStringValue($path);
        
        $this->assertFalse($factoryStringValue_1 === $factoryStringValue_2);
    }
}