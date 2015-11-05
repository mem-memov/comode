<?php
class AnswerFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $nodeFactory;
    protected $complimentFactory;
    
    protected function setUp()
    {
        $this->nodeFactory = $this->getMockBuilder('Comode\syntax\node\IFactory')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->complimentFactory = $this->getMockBuilder('Comode\syntax\IComplimentFactory')
                            ->disableOriginalConstructor()
                            ->getMock();
    }
    
    public function testItProvidesStringAnswer()
    {
        $answerFactory = new Comode\syntax\AnswerFactory($this->nodeFactory);
        $answerFactory->setComplimentFactory($this->complimentFactory);
        
        $answerNode = $this->getMockBuilder('Comode\syntax\node\IStringAnswer')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->nodeFactory->method('createStringAnswerNode')
                        ->willReturn($answerNode);
        
        $answer = $answerFactory->provideStringAnswer('today');
        
        $this->assertInstanceOf('Comode\syntax\StringAnswer', $answer);
    }
    
    public function testItProvidesFileAnswer()
    {
        $answerFactory = new Comode\syntax\AnswerFactory($this->nodeFactory);
        $answerFactory->setComplimentFactory($this->complimentFactory);
        
        $answerNode = $this->getMockBuilder('Comode\syntax\node\IFileAnswer')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->nodeFactory->method('createFileAnswerNode')
                        ->willReturn($answerNode);
        
        $answer = $answerFactory->provideFileAnswer(__FILE__);
        
        $this->assertInstanceOf('Comode\syntax\IAnswer', $answer);
    }
    
    public function itProvideAnswersByCompliment()
    {
        $answerFactory = new Comode\syntax\AnswerFactory($this->nodeFactory);
        $answerFactory->setComplimentFactory($this->complimentFactory);
        
        $complimentNode = $this->getMockBuilder('Comode\syntax\node\ICompliment')
                    ->disableOriginalConstructor()
                    ->getMock();

        $answerNode = $this->getMockBuilder('Comode\syntax\node\IAnswer')
                    ->disableOriginalConstructor()
                    ->getMock();
                    
        $this->nodeFactory->method('getAnswerNodes')
                        ->willReturn([$answerNode]);
        
        $answers = $answerFactory->provideAnswersByCompliment($complimentNode);
        
        $this->assertContainsOnlyInstancesOf('Comode\syntax\IAnswer', $answers);
    }
}