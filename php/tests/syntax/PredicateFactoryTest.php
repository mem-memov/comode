<?php
class PredicateFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $nodeFactory;
    protected $argumentFactory;
    
    protected function setUp()
    {
        $this->nodeFactory = $this->getMockBuilder('Comode\syntax\node\IFactory')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->argumentFactory = $this->getMockBuilder('Comode\syntax\IArgumentFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItProvidesPredicate()
    {
        $predicateFactory = new Comode\syntax\PredicateFactory($this->nodeFactory);
        $predicateFactory->setArgumentFactory($this->argumentFactory);
        
        $predicateNode = $this->getMockBuilder('Comode\syntax\node\IPredicate')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->nodeFactory->method('createPredicateNode')
                        ->willReturn($predicateNode);
        
        $predicate = $predicateFactory->providePredicate('make');
        
        $this->assertInstanceOf('Comode\syntax\IPredicate', $predicate);
    }
    
    public function testItProvidePredicatesByArgument()
    {
        $predicateFactory = new Comode\syntax\PredicateFactory($this->nodeFactory);
        $predicateFactory->setArgumentFactory($this->argumentFactory);
        
        $argumentNode = $this->getMockBuilder('Comode\syntax\node\IArgument')
                    ->disableOriginalConstructor()
                    ->getMock();

        $predicateNode = $this->getMockBuilder('Comode\syntax\node\IPredicate')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->nodeFactory->method('getPredicateNodes')
                        ->willReturn([$predicateNode]);
        
        $predicates = $predicateFactory->providePredicatesByArgument($argumentNode);
        
        $this->assertContainsOnlyInstancesOf('Comode\syntax\IPredicate', $predicates);
    }
}