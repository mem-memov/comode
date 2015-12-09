<?php
namespace Comode\syntax;

class QuestionTest extends \PHPUnit_Framework_TestCase
{
    protected $node;
    protected $argumentFactory;
    
    protected function setUp()
    {
        $this->node = $this->getMockBuilder('Comode\syntax\node\IQuestion')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->argumentFactory = $this->getMockBuilder('Comode\syntax\IArgumentFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItSuppliesId()
    {
        $question = new Question($this->argumentFactory, $this->node);
        
        $id = 7773;
        
        $this->node->expects($this->once())
                        ->method('getId')
                        ->willReturn($id);
                        
        $questionId = $question->getId();
        
        $this->assertEquals($questionId, $id);
    }
    
    public function testItProvidesValue()
    {
        $question = new Question($this->argumentFactory, $this->node);
        
        $value = '{"type":"string","value":"when"}';

        $this->node->method('getValue')
                        ->willReturn($value);
                        
        $questionValue = $question->getValue();
        
        $this->assertEquals($questionValue, $value);
    }
    
    public function testItGetsLinkedToArguments()
    {
        $question = new Question($this->argumentFactory, $this->node);
        
        $argumentNode = $this->getMockBuilder('Comode\syntax\node\IArgument')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->node->expects($this->once())
                    ->method('addNode')
                    ->with($argumentNode);
                    
        $argumentNode->expects($this->once())
                    ->method('addNode')
                    ->with($this->node);
        
        $question->addArgument($argumentNode);
    }
    
    public function testItProvidesArguments()
    {
        $question = new Question($this->argumentFactory, $this->node);
        
        $argument = $this->getMockBuilder('Comode\syntax\IArgument')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->argumentFactory->method('provideArgumentsByQuestion')
                        ->willReturn([$argument]);
        
        $arguments = $question->provideArguments();
        
        $this->assertContainsOnlyInstancesOf('Comode\syntax\IArgument', $arguments);
    }
}