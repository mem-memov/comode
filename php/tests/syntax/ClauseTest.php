<?php
namespace Comode\syntax;

class ClauseTest extends \PHPUnit_Framework_TestCase
{
    protected $node;
    protected $complimentFactory;
    protected $complimentSequence;
    
    protected function setUp()
    {
        $this->node = $this->getMockBuilder('Comode\syntax\node\IClause')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->complimentFactory = $this->getMockBuilder('Comode\syntax\IComplimentFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->complimentSequence = $this->getMockBuilder('Comode\syntax\node\sequence\ICompliment')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItSuppliesId()
    {
        $clause = new Clause($this->complimentFactory, $this->complimentSequence, $this->node);
        
        $id = 7773;
        
        $this->node->expects($this->once())
                        ->method('getId')
                        ->willReturn($id);
                        
        $clauseId = $clause->getId();
        
        $this->assertEquals($clauseId, $id);
    }
    
    public function testItGetsLinkedToCompliments()
    {
        $clause = new Clause($this->complimentFactory, $this->complimentSequence, $this->node);
        
        $compliment = $this->getMockBuilder('Comode\syntax\ICompliment')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $compliment->expects($this->once())
                    ->method('addClause')
                    ->with($this->complimentSequence);

        $clause->addCompliment($compliment);
    }
    
    public function testItProvidesCompliments()
    {
        $clause = new Clause($this->complimentFactory, $this->complimentSequence, $this->node);
        
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