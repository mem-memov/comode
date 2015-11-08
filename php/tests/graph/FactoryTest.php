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
                            
        $this->configuration = $this->getMockBuilder('Comode\graph\IConfiguration')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->configuration->expects($this->any())
                            ->method('makeNodeFactory')
                            ->willReturn($this->nodeFactory);
                            
        $this->configuration->expects($this->any())
                            ->method('makeValueFactory')
                            ->willReturn($this->valueFactory);
    }

    public function testItCreatesANewNodeWithNoValue()
    {
        $factory = new Comode\graph\Factory($this->configuration);
        
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
        $factory = new Comode\graph\Factory($this->configuration);
        
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
        $factory = new Comode\graph\Factory($this->configuration);
        
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
        $factory = new Comode\graph\Factory($this->configuration);
        
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
        $factory = new Comode\graph\Factory($this->configuration);
        
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
        $factory = new Comode\graph\Factory($this->configuration);
        
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
    
/*

    public function testItCreatesNewInstancesOfTheSameStringValue()
    {
        $node = $this->factory->createStringNode('some text');
        $value_1 = $this->factory->makeStringValue('some text');
        $value_2 = $this->factory->makeStringValue('some text');
        $this->assertFalse($value_1 === $value_2);
    }
    
    public function testItRetrievesAFileValue()
    {
        $filePath = $this->path . '/myTestFile.txt';
        file_put_contents($filePath, 'some file content');
        
        $node = $this->factory->createFileNode($filePath);

        $value = $this->factory->makeFileValue($filePath);

        $this->assertInstanceOf('Comode\graph\IValue', $value);
    }
    
    public function testItCreatesNewInstancesOfTheSameFileValue()
    {
        $filePath = $this->path . '/myTestFile.txt';
        file_put_contents($filePath, 'some file content');
        
        $node = $this->factory->createFileNode($filePath);
        $value_1 = $this->factory->makeFileValue($filePath);
        $value_2 = $this->factory->makeFileValue($filePath);
        $this->assertEquals(false, $value_1 === $value_2);
    }
    */
}