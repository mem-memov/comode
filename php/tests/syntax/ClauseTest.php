<?php
class ClauseTest extends \PHPUnit_Framework_TestCase
{
    protected $node;
    protected $complimentFactory;
    
    protected function setUp()
    {
        $this->node = $this->getMockBuilder('Comode\syntax\node\IClause')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->complimentFactory = $this->getMockBuilder('Comode\syntax\IComplimentFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItSuppliesId()
    {
        $clause = new Comode\syntax\Clause($this->complimentFactory, $this->node);
        
        $id = 7773;
        
        $this->node->expects($this->once())
                        ->method('getId')
                        ->willReturn($id);
                        
        $clauseId = $clause->getId();
        
        $this->assertEquals($clauseId, $id);
    }
    
    public function testItGetsLinkedToCompliments()
    {
        $clause = new Comode\syntax\Clause($this->complimentFactory, $this->node);
        
        $complimentNode = $this->getMockBuilder('Comode\syntax\node\ICompliment')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->node->expects($this->once())
                    ->method('addNode')
                    ->with($complimentNode);
                    
        $complimentNode->expects($this->once())
                    ->method('addNode')
                    ->with($this->node);
        
        $clause->addCompliment($complimentNode);
    }
    
    public function testItProvidesCompliments()
    {
        $clause = new Comode\syntax\Clause($this->complimentFactory, $this->node);
        
        $compliment = $this->getMockBuilder('Comode\syntax\ICompliment')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->complimentFactory->expects($this->once())
                        ->method('provideComplimentsByClause')
                        ->with($this->node)
                        ->willReturn([$compliment]);
        
        $compliments = $clause->provideCompliments();
        
        $this->assertContainsOnlyInstancesOf('Comode\syntax\ICompliment', $compliments);
    }
}