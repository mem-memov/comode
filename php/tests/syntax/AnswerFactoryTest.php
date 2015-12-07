<?php
namespace Comode\syntax;

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
    
    public function testItProvidesAnswer()
    {
        $answerFactory = new AnswerFactory($this->nodeFactory);
        $answerFactory->setComplimentFactory($this->complimentFactory);
        
        $answerNode = $this->getMockBuilder('Comode\syntax\node\IAnswer')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->nodeFactory->method('createAnswerNode')
                        ->willReturn($answerNode);
        
        $structure = ['type'=>'string', 'content'=>'today'];
        
        $answer = $answerFactory->provideAnswer($structure);
        
        $this->assertInstanceOf('Comode\syntax\IAnswer', $answer);
    }

    public function itProvideAnswersByCompliment()
    {
        $answerFactory = new AnswerFactory($this->nodeFactory);
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