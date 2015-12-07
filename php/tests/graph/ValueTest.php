<?php
namespace Comode\graph;

class ValueTest extends \PHPUnit_Framework_TestCase
{
    protected $store;
    protected $nodeFactory;
    protected $storeValue;
    
    protected function setUp()
    {
        $this->store = $this->getMockBuilder('Comode\graph\store\IStore')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->nodeFactory = $this->getMockBuilder('Comode\graph\INodeFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->storeValue = $this->getMockBuilder('Comode\graph\store\IValue')
                            ->disableOriginalConstructor()
                            ->getMock();
    }

    public function testItProvidesItsNode()
    {
        $structure = ['type'=>'string', 'content'=>'rabbit'];

        $this->store->expects($this->once())
                    ->method('getValue')
                    ->willReturn($this->storeValue);

        $stringValue = new Value($this->store, $this->nodeFactory, $structure);
        
        $nodeId = 1234;
        
        $this->store->expects($this->once())
                    ->method('getValueNode')
                    ->willReturn($nodeId);
                    
        $node = $this->getMockBuilder('Comode\graph\Node')
                            ->disableOriginalConstructor()
                            ->getMock();
                    
        $this->nodeFactory->expects($this->once())
                    ->method('readNode')
                    ->with($nodeId)
                    ->willReturn($node);
                    
        $valueNode = $stringValue->getNode();
        
        $this->assertEquals($valueNode, $node);
    }
    
    public function testItSuppliesItsStructure()
    {
        $structure = ['type'=>'string', 'content'=>'rabbit'];

        $this->store->expects($this->once())
                    ->method('getValue')
                    ->willReturn($this->storeValue);

        $value = new Value($this->store, $this->nodeFactory, $structure);

        $valueStructure = $value->getStructure();
        
        $this->assertEquals($valueStructure, $structure);
    }
}