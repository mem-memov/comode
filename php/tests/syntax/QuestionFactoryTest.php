<?php
namespace Comode\syntax;

class QuestionFactoryTest extends \PHPUnit_Framework_TestCase
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
    
    public function testItProvidesQuestion()
    {
        $questionFactory = new QuestionFactory($this->nodeFactory);
        $questionFactory->setArgumentFactory($this->argumentFactory);
        
        $questionNode = $this->getMockBuilder('Comode\syntax\node\IQuestion')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->nodeFactory->method('createQuestionNode')
                        ->willReturn($questionNode);
                        
        $structure = ['type'=>'string', 'content'=>'when'];
        
        $question = $questionFactory->provideQuestion($structure);
        
        $this->assertInstanceOf('Comode\syntax\IQuestion', $question);
    }
    
    public function testItProvideQuestionsByArgument()
    {
        $questionFactory = new QuestionFactory($this->nodeFactory);
        $questionFactory->setArgumentFactory($this->argumentFactory);
        
        $argumentNode = $this->getMockBuilder('Comode\syntax\node\IArgument')
                    ->disableOriginalConstructor()
                    ->getMock();

        $questionNode = $this->getMockBuilder('Comode\syntax\node\IQuestion')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->nodeFactory->method('getQuestionNodes')
                        ->willReturn([$questionNode]);
        
        $questions = $questionFactory->provideQuestionsByArgument($argumentNode);
        
        $this->assertContainsOnlyInstancesOf('Comode\syntax\IQuestion', $questions);
    }
}