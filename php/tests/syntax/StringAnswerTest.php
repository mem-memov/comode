<?php
class StringAnswerTest extends \PHPUnit_Framework_TestCase
{
    protected $node;
    protected $complimentFactory;
    
    protected function setUp()
    {
        $this->node = $this->getMockBuilder('Comode\syntax\node\IStringAnswer')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->complimentFactory = $this->getMockBuilder('Comode\syntax\IComplimentFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItSuppliesId()
    {
        $answer = new Comode\syntax\StringAnswer($this->complimentFactory, $this->node);
        
        $id = 7773;
        
        $this->node->method('getId')
                        ->willReturn($id);
                        
        $answerId = $answer->getId();
        
        $this->assertEquals($answerId, $id);
    }
    
    public function testItProvidesValue()
    {
        $answer = new Comode\syntax\StringAnswer($this->complimentFactory, $this->node);
        
        $answerString = 'today';
        
        $value = $this->getMockBuilder('Comode\graph\IValue')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $value->method('getContent')
                        ->willReturn($answerString);
        
        $this->node->method('getValue')
                        ->willReturn($value);
                        
        $answerValue = $answer->getValue();
        
        $this->assertEquals($answerValue, $answerString);
    }
    
    public function testItGetsLinkedToCompliments()
    {
        $answer = new Comode\syntax\StringAnswer($this->complimentFactory, $this->node);
        
        $complimentNode = $this->getMockBuilder('Comode\syntax\node\ICompliment')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->node->expects($this->once())
                    ->method('addNode')
                    ->with($complimentNode);
                    
        $complimentNode->expects($this->once())
                    ->method('addNode')
                    ->with($this->node);
        
        $answer->addCompliment($complimentNode);
    }
    
    public function testItProvidesCompliments()
    {
        $answer = new Comode\syntax\StringAnswer($this->complimentFactory, $this->node);
        
        $compliment = $this->getMockBuilder('Comode\syntax\ICompliment')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->complimentFactory->method('provideComplimentsByAnswer')
                        ->willReturn([$compliment]);
        
        $compliments = $answer->provideCompliments();
        
        $this->assertContainsOnlyInstancesOf('Comode\syntax\ICompliment', $compliments);
    }
    
    public function testItDeniesBeingAFile()
    {
        $answer = new Comode\syntax\StringAnswer($this->complimentFactory, $this->node);
        
        $this->assertEquals(false, $answer->isFile());
    }
}