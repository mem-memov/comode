<?php
namespace Comode\syntax;

class ComplimentFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $nodeFactory;
    protected $clauseFactory;
    protected $argumentFactory;
    protected $answerFactory;

    
    protected function setUp()
    {
        $this->nodeFactory = $this->getMockBuilder('Comode\syntax\node\IFactory')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->clauseFactory = $this->getMockBuilder('Comode\syntax\IClauseFactory')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->argumentFactory = $this->getMockBuilder('Comode\syntax\IArgumentFactory')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->answerFactory = $this->getMockBuilder('Comode\syntax\IAnswerFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItReadsCompliment()
    {
        $complimentFactory = new ComplimentFactory($this->nodeFactory, $this->argumentFactory, $this->answerFactory);
        $complimentFactory->setClauseFactory($this->clauseFactory);
        
        $argument = $this->getMockBuilder('Comode\syntax\IArgument')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $answer = $this->getMockBuilder('Comode\syntax\IAnswer')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $compliment = $this->getMockBuilder('Comode\syntax\ICompliment')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $argument->method('provideComplimentByAnswer')
                        ->willReturn($compliment);
        
        $compliment = $complimentFactory->provideCompliment($argument, $answer);
        
        $this->assertInstanceOf('Comode\syntax\ICompliment', $compliment);
    }
    
    public function testItCreatesCompliment()
    {
        $complimentFactory = new ComplimentFactory($this->nodeFactory, $this->argumentFactory, $this->answerFactory);
        $complimentFactory->setClauseFactory($this->clauseFactory);
        
        $argument = $this->getMockBuilder('Comode\syntax\IArgument')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $answer = $this->getMockBuilder('Comode\syntax\IAnswer')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $argument->method('provideComplimentByAnswer')
                        ->will($this->throwException(new exception\ArgumentAndAnswerHaveOneCommonCompliment()));
                        
        $complimentNode = $this->getMockBuilder('Comode\syntax\node\ICompliment')
                    ->disableOriginalConstructor()
                    ->getMock();
                    
        $this->nodeFactory->method('createComplimentNode')
                        ->willReturn($complimentNode);
                        
        $argument->expects($this->once())
                    ->method('addCompliment')
                    ->with($complimentNode);
        
        $answer->expects($this->once())
                    ->method('addCompliment')
                    ->with($complimentNode);
        
        $compliment = $complimentFactory->provideCompliment($argument, $answer);
        
        $this->assertInstanceOf('Comode\syntax\ICompliment', $compliment);
    }
    
    public function testItProvidesComplimentsByClause()
    {
        $complimentFactory = new ComplimentFactory($this->nodeFactory, $this->argumentFactory, $this->answerFactory);
        $complimentFactory->setClauseFactory($this->clauseFactory);
        
        $clauseNode = $this->getMockBuilder('Comode\syntax\node\IClause')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $complimentNode = $this->getMockBuilder('Comode\syntax\node\ICompliment')
                    ->disableOriginalConstructor()
                    ->getMock();
                    
        $this->nodeFactory->method('getComplimentNodes')
                        ->willReturn([$complimentNode]);
        
        $compliments = $complimentFactory->provideComplimentsByClause($clauseNode);
        
        $this->assertContainsOnlyInstancesOf('Comode\syntax\ICompliment', $compliments);
    }
    
    public function testItProvidesComplimentsByArgument()
    {
        $complimentFactory = new ComplimentFactory($this->nodeFactory, $this->argumentFactory, $this->answerFactory);
        $complimentFactory->setClauseFactory($this->clauseFactory);
        
        $argumentNode = $this->getMockBuilder('Comode\syntax\node\IArgument')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $complimentNode = $this->getMockBuilder('Comode\syntax\node\ICompliment')
                    ->disableOriginalConstructor()
                    ->getMock();
                    
        $this->nodeFactory->method('getComplimentNodes')
                        ->willReturn([$complimentNode]);
        
        $compliments = $complimentFactory->provideComplimentsByArgument($argumentNode);
        
        $this->assertContainsOnlyInstancesOf('Comode\syntax\ICompliment', $compliments);
    }
    
    public function testItProvidesComplimentsByAnswer()
    {
        $complimentFactory = new ComplimentFactory($this->nodeFactory, $this->argumentFactory, $this->answerFactory);
        $complimentFactory->setClauseFactory($this->clauseFactory);
        
        $answerNode = $this->getMockBuilder('Comode\syntax\node\IAnswer')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $complimentNode = $this->getMockBuilder('Comode\syntax\node\ICompliment')
                    ->disableOriginalConstructor()
                    ->getMock();
                    
        $this->nodeFactory->method('getComplimentNodes')
                        ->willReturn([$complimentNode]);
        
        $compliments = $complimentFactory->provideComplimentsByAnswer($answerNode);
        
        $this->assertContainsOnlyInstancesOf('Comode\syntax\ICompliment', $compliments);
    }
}