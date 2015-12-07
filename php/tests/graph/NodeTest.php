<?php
namespace Comode\graph;

class NodeTest extends \PHPUnit_Framework_TestCase
{
    protected $store;
    protected $valueFactory;
    protected $nodeFactory;
    protected $id;

    protected function setUp()
    {
        $this->store = $this->getMockBuilder('Comode\graph\store\IStore')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->valueFactory = $this->getMockBuilder('Comode\graph\IValueFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->nodeFactory = $this->getMockBuilder('Comode\graph\INodeFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->id = 3;
    }
    
    public function testItGetsCreatedByStoreWhenNoIdProvided()
    {
        $this->store->expects($this->once())
                    ->method('createNode')
                    ->willReturn($this->id);

        $node = new Node($this->store, $this->valueFactory, $this->nodeFactory);
        
        $this->assertEquals($this->id, $node->getId());
    }
    
    public function testItGetsCreatedWithAValueWhenStructureProvided()
    {
        $structure = ['type'=>'string', 'content'=>'rabbit'];
        
        $this->store->expects($this->once())
                    ->method('createNode')
                    ->with($structure)
                    ->willReturn($this->id);

        $node = new Node($this->store, $this->valueFactory, $this->nodeFactory, null, $structure);
    }

    public function testItKeepsItsIdIfInStore()
    {
        $this->store->expects($this->once())
                    ->method('nodeExists')
                    ->willReturn(true);

        $node = new Node($this->store, $this->valueFactory, $this->nodeFactory, $this->id);
        
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

        $node = new Node($this->store, $this->valueFactory, $this->nodeFactory, $this->id);
    }
    
    public function testItProvidesItsOwnId()
    {
        $this->store->expects($this->once())
                    ->method('nodeExists')
                    ->willReturn(true);

        $node = new Node($this->store, $this->valueFactory, $this->nodeFactory, $this->id);
        
        $nodeId = $node->getId();
        
        $this->assertEquals($this->id, $nodeId);
    }
    
    public function testItCanBeConnectedToOtherNodes()
    {
        $this->store->expects($this->once())
                    ->method('nodeExists')
                    ->willReturn(true);

        $node = new Node($this->store, $this->valueFactory, $this->nodeFactory, $this->id);
        
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

        $node = new Node($this->store, $this->valueFactory, $this->nodeFactory, $this->id);
        
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

        $node = new Node($this->store, $this->valueFactory, $this->nodeFactory, $this->id);
           
        $linkedNodeId = $this->id + 2222;
        
        $this->store->expects($this->once())
                    ->method('getLinkedNodes')
                    ->with($this->id)
                    ->willReturn([$linkedNodeId]);
                    
        $linkedNode = $this->getMockBuilder('Comode\graph\INode')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->nodeFactory->expects($this->once())
                    ->method('readNode')
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

        $node = new Node($this->store, $this->valueFactory, $this->nodeFactory, $this->id);
        
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

        $node = new Node($this->store, $this->valueFactory, $this->nodeFactory, $this->id);
        
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

        $structure = ['type'=>'string', 'content'=>'rabbit'];

        $node = new Node($this->store, $this->valueFactory, $this->nodeFactory, null, $structure);
        
        $storeValue = $this->getMockBuilder('Comode\graph\store\value\IValue')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->store->expects($this->once())
                    ->method('getNodeValue')
                    ->with($this->id)
                    ->willReturn($storeValue);

        $value = $this->getMockBuilder('Comode\graph\IValue')
                            ->disableOriginalConstructor()
                            ->getMock();
                    
        $this->valueFactory->expects($this->once())
                    ->method('makeValue')
                    ->with($storeValue)
                    ->willReturn($value);
        
        $nodeValue = $node->getValue();
        
        $this->assertInstanceOf('Comode\graph\IValue', $nodeValue);
    }

    public function testItSuppliesCommonNodes()
    {
        $this->store->expects($this->once())
                    ->method('nodeExists')
                    ->willReturn(true);

        $node = new Node($this->store, $this->valueFactory, $this->nodeFactory, $this->id);
        
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
                    
        $this->nodeFactory->expects($this->once())
                    ->method('readNode')
                    ->with($commonNodeId)
                    ->willReturn($commonNode);
                    
        $commonNodes = $node->getCommonNodes($adjacentNode);

        $this->assertEquals($commonNodes[0], $commonNode);
    }
}