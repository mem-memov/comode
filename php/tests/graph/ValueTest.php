<?php
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
        $isFile = false;
        $content = 'rabbit';

        $this->store->expects($this->once())
                    ->method('getValue')
                    ->willReturn($this->storeValue);

        $stringValue = new Comode\graph\Value($this->store, $this->nodeFactory, $isFile, $content);
        
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
    
    public function testItSuppliesItsContent()
    {
        $isFile = false;
        $content = 'rabbit';

        $this->store->expects($this->once())
                    ->method('getValue')
                    ->willReturn($this->storeValue);

        $stringValue = new Comode\graph\Value($this->store, $this->nodeFactory, $isFile, $content);
        
        $this->storeValue->expects($this->once())
                    ->method('getContent')
                    ->willReturn($content);
        
        $valueContent = $stringValue->getContent();
        
        $this->assertEquals($valueContent, $content);
    }
    
    public function testItConfirmsToBeAFile()
    {
        $isFile = true;
        $content = '/tmp/some.file';

        $this->store->expects($this->once())
                    ->method('getValue')
                    ->willReturn($this->storeValue);

        $stringValue = new Comode\graph\Value($this->store, $this->nodeFactory, $isFile, $content);
        
        $this->storeValue->expects($this->once())
                    ->method('isFile')
                    ->willReturn($isFile);
        
        $valueIsFile = $stringValue->isFile();
        
        $this->assertEquals($valueIsFile, $isFile);
    }
    
    public function testItDeniesToBeAFile()
    {
        $isFile = false;
        $content = 'rabbit';

        $this->store->expects($this->once())
                    ->method('getValue')
                    ->willReturn($this->storeValue);

        $stringValue = new Comode\graph\Value($this->store, $this->nodeFactory, $isFile, $content);
        
        $this->storeValue->expects($this->once())
                    ->method('isFile')
                    ->willReturn($isFile);
        
        $valueIsFile = $stringValue->isFile();
        
        $this->assertEquals($valueIsFile, $isFile);
    }
}