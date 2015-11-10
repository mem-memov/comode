<?php
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
        $valueFactory = new Comode\graph\ValueFactory($this->store);
        $valueFactory->setNodeFactory($this->nodeFactory);
    }
    
    public function testItRetrievesAStringValue()
    {
        $valueFactory = new Comode\graph\ValueFactory($this->store);
        $valueFactory->setNodeFactory($this->nodeFactory);
        
        $string = 'rabbit';
        
        $factoryValue = $valueFactory->makeStringValue($string);
        
        $this->assertInstanceOf('Comode\graph\IValue', $factoryValue);
    }
    
    public function testItCreatesNewInstancesOfTheSameStringValue()
    {
        $valueFactory = new Comode\graph\ValueFactory($this->store);
        $valueFactory->setNodeFactory($this->nodeFactory);
        
        $string = 'rabbit';
        
        $factoryValue_1 = $valueFactory->makeStringValue($string);
        $factoryValue_2 = $valueFactory->makeStringValue($string);
        
        $this->assertFalse($factoryValue_1 === $factoryValue_2);
    }
    
    public function testItRetrievesAFileValue()
    {
        $valueFactory = new Comode\graph\ValueFactory($this->store);
        $valueFactory->setNodeFactory($this->nodeFactory);
        
        $path = '/tmp/some.file';
        
        $factoryValue = $valueFactory->makeFileValue($path);
        
        $this->assertInstanceOf('Comode\graph\IValue', $factoryValue);
    }
    
    public function testItCreatesNewInstancesOfTheSameFileValue()
    {
        $valueFactory = new Comode\graph\ValueFactory($this->store);
        $valueFactory->setNodeFactory($this->nodeFactory);
        
        $path = '/tmp/some.file';
        
        $factoryValue_1 = $valueFactory->makeStringValue($path);
        $factoryValue_2 = $valueFactory->makeStringValue($path);
        
        $this->assertFalse($factoryValue_1 === $factoryValue_2);
    }

}