<?php
namespace Comode\syntax;

class PredicateTest extends \PHPUnit_Framework_TestCase
{
    protected $node;
    protected $argumentFactory;
    
    protected function setUp()
    {
        $this->node = $this->getMockBuilder('Comode\syntax\node\IPredicate')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->argumentFactory = $this->getMockBuilder('Comode\syntax\IArgumentFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItSuppliesId()
    {
        $predicate = new Predicate($this->argumentFactory, $this->node);
        
        $id = 7773;
        
        $this->node->expects($this->once())
                        ->method('getId')
                        ->willReturn($id);
                        
        $predicateId = $predicate->getId();
        
        $this->assertEquals($predicateId, $id);
    }
    
    public function testItProvidesValue()
    {
        $predicate = new Predicate($this->argumentFactory, $this->node);
        
        $predicateString = 'make';
        
        $value = $this->getMockBuilder('Comode\graph\IValue')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $value->method('getContent')
                        ->willReturn($predicateString);
        
        $this->node->method('getValue')
                        ->willReturn($value);
                        
        $predicateValue = $predicate->getValue();
        
        $this->assertEquals($predicateValue, $predicateString);
    }
    
    public function testItGetsLinkedToArguments()
    {
        $predicate = new Predicate($this->argumentFactory, $this->node);
        
        $argumentNode = $this->getMockBuilder('Comode\syntax\node\IArgument')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->node->expects($this->once())
                    ->method('addNode')
                    ->with($argumentNode);
                    
        $argumentNode->expects($this->once())
                    ->method('addNode')
                    ->with($this->node);
        
        $predicate->addArgument($argumentNode);
    }
    
    public function testItProvidesArguments()
    {
        $predicate = new Predicate($this->argumentFactory, $this->node);
        
        $argument = $this->getMockBuilder('Comode\syntax\IArgument')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->argumentFactory->method('provideArgumentsByPredicate')
                        ->willReturn([$argument]);
        
        $arguments = $predicate->provideArguments();
        
        $this->assertContainsOnlyInstancesOf('Comode\syntax\IArgument', $arguments);
    }
    
    public function testItProvidesArgumentByQuestion()
    {
        $predicate = new Predicate($this->argumentFactory, $this->node);
        
        $question = $this->getMockBuilder('Comode\syntax\IQuestion')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $argument = $this->getMockBuilder('Comode\syntax\IArgument')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->argumentFactory->expects($this->once())
                    ->method('provideArgumentsByPredicate')
                    ->with($this->node)
                    ->willReturn([$argument]); 

        $argument->expects($this->once())
                    ->method('provideQuestion')
                    ->willReturn($question);

        $question->expects($this->any())
                    ->method('getId')
                    ->willReturn(5777123);
        
        $argument = $predicate->provideArgumentByQuestion($question);
        
        $this->assertInstanceOf('Comode\syntax\IArgument', $argument);
    }
    
    /**
     * @expectedException Comode\syntax\exception\PredicateAndQuestionHaveOneCommonArgument
     */
    public function testItPanicsWhenNoArgumentForQuestion()
    {
        $predicate = new Predicate($this->argumentFactory, $this->node);
        
        $question = $this->getMockBuilder('Comode\syntax\IQuestion')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->argumentFactory->expects($this->once())
                    ->method('provideArgumentsByPredicate')
                    ->with($this->node)
                    ->willReturn([]); 

        $argument = $predicate->provideArgumentByQuestion($question);
    }
}