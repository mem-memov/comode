<?php
namespace Comode\graph;

class ValueFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $store;
    protected $nodeFactory;
    
    protected function setUp()
    {
        $this->store = $this->getMockBuilder('Comode\graph\store\IStore')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->nodeFactory = $this->getMockBuilder('Comode\graph\INodeFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItGetsNodeFactory()
    {
        $valueFactory = new ValueFactory($this->store);
        $valueFactory->setNodeFactory($this->nodeFactory);
    }
    
    public function testItRetrievesAValue()
    {
        $valueFactory = new ValueFactory($this->store);
        $valueFactory->setNodeFactory($this->nodeFactory);
        
        $structure = ['type'=>'string', 'content'=>'rabbit'];
        
        $factoryValue = $valueFactory->makeValue($structure);
        
        $this->assertInstanceOf('Comode\graph\IValue', $factoryValue);
    }
    
    public function testItCreatesNewInstancesOfTheSameValue()
    {
        $valueFactory = new ValueFactory($this->store);
        $valueFactory->setNodeFactory($this->nodeFactory);
        
        $structure = ['type'=>'string', 'content'=>'rabbit'];
        
        $factoryValue_1 = $valueFactory->makeValue($structure);
        $factoryValue_2 = $valueFactory->makeValue($structure);
        
        $this->assertFalse($factoryValue_1 === $factoryValue_2);
    }
}