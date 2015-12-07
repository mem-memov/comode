<?php
namespace Comode\syntax;

class ArgumentFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $nodeFactory;
    protected $predicateFactory;
    protected $questionFactory;
    protected $complimentFactory;

    
    protected function setUp()
    {
        $this->nodeFactory = $this->getMockBuilder('Comode\syntax\node\IFactory')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->predicateFactory = $this->getMockBuilder('Comode\syntax\IPredicateFactory')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->questionFactory = $this->getMockBuilder('Comode\syntax\IQuestionFactory')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->complimentFactory = $this->getMockBuilder('Comode\syntax\IComplimentFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItReadsArgument()
    {
        $argumentFactory = new ArgumentFactory($this->nodeFactory, $this->predicateFactory, $this->questionFactory);
        $argumentFactory->setComplimentFactory($this->complimentFactory);
        
        $predicate = $this->getMockBuilder('Comode\syntax\IPredicate')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $question = $this->getMockBuilder('Comode\syntax\IQuestion')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $argument = $this->getMockBuilder('Comode\syntax\IArgument')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $predicate->method('provideArgumentByQuestion')
                        ->willReturn($argument);
        
        $argument = $argumentFactory->provideArgument($predicate, $question);
        
        $this->assertInstanceOf('Comode\syntax\IArgument', $argument);
    }
    
    public function testItCreatesArgument()
    {
        $argumentFactory = new ArgumentFactory($this->nodeFactory, $this->predicateFactory, $this->questionFactory);
        $argumentFactory->setComplimentFactory($this->complimentFactory);
        
        $predicate = $this->getMockBuilder('Comode\syntax\IPredicate')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $question = $this->getMockBuilder('Comode\syntax\IQuestion')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $predicate->method('provideArgumentByQuestion')
                        ->will($this->throwException(new exception\PredicateAndQuestionHaveOneCommonArgument()));
                        
        $argumentNode = $this->getMockBuilder('Comode\syntax\node\IArgument')
                    ->disableOriginalConstructor()
                    ->getMock();
                    
        $this->nodeFactory->method('createArgumentNode')
                        ->willReturn($argumentNode);
                        
        $predicate->expects($this->once())
                    ->method('addArgument')
                    ->with($argumentNode);
        
        $question->expects($this->once())
                    ->method('addArgument')
                    ->with($argumentNode);
        
        $argument = $argumentFactory->provideArgument($predicate, $question);
        
        $this->assertInstanceOf('Comode\syntax\IArgument', $argument);
    }
    
    public function testItProvidesArgumentsByQuestion()
    {
        $argumentFactory = new ArgumentFactory($this->nodeFactory, $this->predicateFactory, $this->questionFactory);
        $argumentFactory->setComplimentFactory($this->complimentFactory);
        
        $questionNode = $this->getMockBuilder('Comode\syntax\node\IQuestion')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $argumentNode = $this->getMockBuilder('Comode\syntax\node\IArgument')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->nodeFactory->method('getArgumentNodes')
                        ->willReturn([$argumentNode]);
        
        $arguments = $argumentFactory->provideArgumentsByQuestion($questionNode);
        
        $this->assertContainsOnlyInstancesOf('Comode\syntax\IArgument', $arguments);
    }
    
    public function testItProvidesArgumentsByPredicate()
    {
        $argumentFactory = new ArgumentFactory($this->nodeFactory, $this->predicateFactory, $this->questionFactory);
        $argumentFactory->setComplimentFactory($this->complimentFactory);
        
        $predicateNode = $this->getMockBuilder('Comode\syntax\node\IPredicate')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $argumentNode = $this->getMockBuilder('Comode\syntax\node\IArgument')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->nodeFactory->method('getArgumentNodes')
                        ->willReturn([$argumentNode]);
        
        $arguments = $argumentFactory->provideArgumentsByPredicate($predicateNode);
        
        $this->assertContainsOnlyInstancesOf('Comode\syntax\IArgument', $arguments);
    }
}