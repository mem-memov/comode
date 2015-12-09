<?php
namespace Comode\graph;

class NodeTest extends \PHPUnit_Framework_TestCase
{
    protected $store;
    protected $factory;
    protected $id;

    protected function setUp()
    {
        $this->store = $this->getMockBuilder('Comode\graph\store\IStore')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->factory = $this->getMockBuilder('Comode\graph\IFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->id = 3;
    }
    
    public function testItGetsCreatedByStoreWhenNoIdProvided()
    {
        $this->store->expects($this->once())
                    ->method('createNode')
                    ->willReturn($this->id);

        $node = new Node($this->store, $this->factory);
        
        $this->assertEquals($this->id, $node->getId());
    }
    
    public function testItGetsCreatedWithAValueWhenProvided()
    {
        $value = '{"someKey":"someValue"}';
        
        $this->store->expects($this->once())
                    ->method('createNode')
                    ->with($value)
                    ->willReturn($this->id);

        $node = new Node($this->store, $this->factory, null, $value);
    }

    public function testItKeepsItsIdIfInStore()
    {
        $this->store->expects($this->once())
                    ->method('nodeExists')
                    ->willReturn(true);

        $node = new Node($this->store, $this->factory, $this->id);
        
        $this->assertEquals($this->id, $node->getId());
    }
    
    /**
     * @expectedException Comode\graph\exception\NodeHasAnId
     */
    public function testItPanicsWhenProvidedIdNotInStore()
    {
        $this->store->expects($this->once())
                    ->method('nodeExists')
                    ->willReturn(false);

        $node = new Node($this->store, $this->factory, $this->id);
    }
    
    public function testItProvidesItsOwnId()
    {
        $this->store->expects($this->once())
                    ->method('nodeExists')
                    ->willReturn(true);

        $node = new Node($this->store, $this->factory, $this->id);
        
        $nodeId = $node->getId();
        
        $this->assertEquals($this->id, $nodeId);
    }
    
    public function testItCanBeConnectedToOtherNodes()
    {
        $this->store->expects($this->once())
                    ->method('nodeExists')
                    ->willReturn(true);

        $node = new Node($this->store, $this->factory, $this->id);
        
        $nodeToAdd = $this->getMockBuilder('Comode\graph\INode')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $nodeToAddId = $this->id + 2222;
        
        $nodeToAdd->expects($this->once())
                    ->method('getId')
                    ->willReturn($nodeToAddId);
                            
        $this->store->expects($this->once())
                    ->method('linkNodes')
                    ->with($this->id, $nodeToAddId);
        
        $node->addNode($nodeToAdd);
    }
    
    public function testItNodesCanBeRemoved()
    {
        $this->store->expects($this->once())
                    ->method('nodeExists')
                    ->willReturn(true);

        $node = new Node($this->store, $this->factory, $this->id);
        
        $nodeToRemove = $this->getMockBuilder('Comode\graph\INode')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $nodeToRemoveId = $this->id + 2222;
        
        $nodeToRemove->expects($this->once())
                    ->method('getId')
                    ->willReturn($nodeToRemoveId);
                    
        $this->store->expects($this->once())
                    ->method('separateNodes')
                    ->with($this->id, $nodeToRemoveId);
                    
        $node->removeNode($nodeToRemove);
    }
    
    public function testItSuppliesItsNodes()
    {
        $this->store->expects($this->once())
                    ->method('nodeExists')
                    ->willReturn(true);

        $node = new Node($this->store, $this->factory, $this->id);
           
        $linkedNodeId = $this->id + 2222;
        
        $this->store->expects($this->once())
                    ->method('getLinkedNodes')
                    ->with($this->id)
                    ->willReturn([$linkedNodeId]);
                    
        $linkedNode = $this->getMockBuilder('Comode\graph\INode')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->factory->expects($this->once())
                    ->method('makeNode')
                    ->with($linkedNodeId)
                    ->willReturn($linkedNode);
        
        $nodes = $node->getNodes();
        
        $this->assertContainsOnlyInstancesOf('Comode\graph\INode', $nodes);
        
        $this->assertEquals($linkedNode, $nodes[0]);
    }
    
    public function testItChecksItHasANode()
    {
        $this->store->expects($this->once())
                    ->method('nodeExists')
                    ->willReturn(true);

        $node = new Node($this->store, $this->factory, $this->id);
        
        $nodeToCheck = $this->getMockBuilder('Comode\graph\INode')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $nodeToCheckId = $this->id + 2222;
        
        $nodeToCheck->expects($this->once())
                    ->method('getId')
                    ->willReturn($nodeToCheckId);
        
        $this->store->expects($this->once())
                    ->method('isLinkedToNode')
                    ->with($this->id, $nodeToCheckId)
                    ->willReturn(true);
        
        $hasNode = $node->hasNode($nodeToCheck);

        $this->assertEquals($hasNode, true);
    }
    
    public function testItChecksItHasNoNode()
    {
        $this->store->expects($this->once())
                    ->method('nodeExists')
                    ->willReturn(true);

        $node = new Node($this->store, $this->factory, $this->id);
        
        $nodeToCheck = $this->getMockBuilder('Comode\graph\INode')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $nodeToCheckId = $this->id + 2222;
        
        $nodeToCheck->expects($this->once())
                    ->method('getId')
                    ->willReturn($nodeToCheckId);
        
        $this->store->expects($this->once())
                    ->method('isLinkedToNode')
                    ->with($this->id, $nodeToCheckId)
                    ->willReturn(false);
        
        $hasNode = $node->hasNode($nodeToCheck);

        $this->assertEquals($hasNode, false);
    }
    
    public function testItSuppliesItsValue()
    {
        $this->store->expects($this->once())
                    ->method('createNode')
                    ->willReturn($this->id);

        $value = '{"someKey":"someValue"}';

        $node = new Node($this->store, $this->factory, null, $value);

        $this->store->expects($this->once())
                    ->method('getNodeValue')
                    ->with($this->id)
                    ->willReturn($value);

        $nodeValue = $node->getValue();
        
        $this->assertEquals($nodeValue, $value);
    }

    public function testItSuppliesCommonNodes()
    {
        $this->store->expects($this->once())
                    ->method('nodeExists')
                    ->willReturn(true);

        $node = new Node($this->store, $this->factory, $this->id);
        
        $adjacentNode = $this->getMockBuilder('Comode\graph\INode')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $adjacentNodeId = $this->id + 2222;
        
        $adjacentNode->expects($this->once())
                    ->method('getId')
                    ->willReturn($adjacentNodeId);

        $commonNode = $this->getMockBuilder('Comode\graph\INode')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $commonNodeId = $adjacentNodeId + 345;
                           
        $this->store->expects($this->exactly(2))
                    ->method('getLinkedNodes')
                    ->withConsecutive(
                        [$this->equalTo($this->id)],
                        [$this->equalTo($adjacentNodeId)]
                    )
                    ->will($this->onConsecutiveCalls(
                        [$commonNodeId], 
                        [$commonNodeId]
                    ));
                    
        $this->factory->expects($this->once())
                    ->method('makeNode')
                    ->with($commonNodeId)
                    ->willReturn($commonNode);
                    
        $commonNodes = $node->getCommonNodes($adjacentNode);

        $this->assertEquals($commonNodes[0], $commonNode);
    }
}