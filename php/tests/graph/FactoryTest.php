<?php
namespace Comode\graph;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $store;

    protected function setUp()
    {
        $this->store = $this->getMockBuilder('Comode\graph\store\IStore')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItCreatesANewNodeWithNoValue()
    {
        $factory = new Factory($this->store);

        $node = $factory->makeNode();
        
        $this->assertInstanceOf('Comode\graph\INode', $node);
    }
    
    public function testItCreatesANewNodeWithAValue()
    {
        $factory = new Factory($this->store);
        
        $value = '{"someKey":"someValue"}';

        $node = $factory->makeNode(null, $value);
        
        $this->assertInstanceOf('Comode\graph\INode', $node);
    }

    public function testItRetrievesANodeByItsId()
    {
        $factory = new Factory($this->store);

        $node_1 = $factory->makeNode();
        
        $nodeId = $node_1->getId();
        
        $node_2 = $factory->makeNode($nodeId);
        
        $this->assertInstanceOf('Comode\graph\INode', $node_2);
        $this->assertEquals($nodeId, $node_2->getId());
    }
    
    public function testItCreatesNewInstancesOfTheSameNode()
    {
        $factory = new Factory($this->store);

        $node_1 = $factory->makeNode();
        
        $nodeId = $node_1->getId();
        
        $node_2 = $factory->makeNode($nodeId);
        
        $this->assertFalse($node_1 === $node_2);
    }
}