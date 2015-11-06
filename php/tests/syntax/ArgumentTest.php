<?php
class ArgumentTest extends \PHPUnit_Framework_TestCase
{
    protected $node;
    protected $predicateFactory;
    protected $questionFactory;
    protected $complimentFactory;
    
    protected function setUp()
    {
        $this->node = $this->getMockBuilder('Comode\syntax\node\IArgument')
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
    
    public function testItSuppliesId()
    {
        $argument = new Comode\syntax\Argument($this->predicateFactory, $this->questionFactory, $this->complimentFactory, $this->node);
        
        $id = 7773;
        
        $this->node->expects($this->once())
                        ->method('getId')
                        ->willReturn($id);
                        
        $argumentId = $argument->getId();
        
        $this->assertEquals($argumentId, $id);
    }
    
    public function testItGetsLinkedToCompliments()
    {
        $argument = new Comode\syntax\Argument($this->predicateFactory, $this->questionFactory, $this->complimentFactory, $this->node);
        
        $complimentNode = $this->getMockBuilder('Comode\syntax\node\ICompliment')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->node->expects($this->once())
                    ->method('addNode')
                    ->with($complimentNode);
                    
        $complimentNode->expects($this->once())
                    ->method('addNode')
                    ->with($this->node);
        
        $argument->addCompliment($complimentNode);
    }
    
    public function testItProvidesCompliments()
    {
        $argument = new Comode\syntax\Argument($this->predicateFactory, $this->questionFactory, $this->complimentFactory, $this->node);
        
        $compliment = $this->getMockBuilder('Comode\syntax\ICompliment')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->complimentFactory->expects($this->once())
                        ->method('provideComplimentsByArgument')
                        ->with($this->node)
                        ->willReturn([$compliment]);
        
        $compliments = $argument->provideCompliments();
        
        $this->assertContainsOnlyInstancesOf('Comode\syntax\ICompliment', $compliments);
    }
    
    public function testItProvidesQuestion()
    {
        $argument = new Comode\syntax\Argument($this->predicateFactory, $this->questionFactory, $this->complimentFactory, $this->node);
        
        $question = $this->getMockBuilder('Comode\syntax\IQuestion')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->questionFactory->expects($this->once())
                                ->method('provideQuestionsByArgument')
                                ->with($this->node)
                                ->willReturn([$question]);
        
        $argumentQuestion = $argument->provideQuestion();
        
        $this->assertInstanceOf('Comode\syntax\IQuestion', $argumentQuestion);
        
        $this->assertEquals($question, $argumentQuestion);
    }

    /**
     * @expectedException Comode\syntax\exception\PredicateAndQuestionHaveOneCommonArgument
     */
    public function testItPanicsWhenNoQuestion()
    {
        $argument = new Comode\syntax\Argument($this->predicateFactory, $this->questionFactory, $this->complimentFactory, $this->node);

        $this->questionFactory->expects($this->once())
                                ->method('provideQuestionsByArgument')
                                ->with($this->node)
                                ->willReturn([]);
        
        $argumentQuestion = $argument->provideQuestion();
    }
    
    /**
     * @expectedException Comode\syntax\exception\PredicateAndQuestionHaveOneCommonArgument
     */
    public function testItPanicsWhenTooManyQuestions()
    {
        $argument = new Comode\syntax\Argument($this->predicateFactory, $this->questionFactory, $this->complimentFactory, $this->node);

        $question_1 = $this->getMockBuilder('Comode\syntax\IQuestion')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $question_2 = $this->getMockBuilder('Comode\syntax\IQuestion')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->questionFactory->expects($this->once())
                                ->method('provideQuestionsByArgument')
                                ->with($this->node)
                                ->willReturn([$question_1, $question_2]);
        
        $argumentQuestion = $argument->provideQuestion();
    }
    
    public function testItProvidesPredicate()
    {
        $argument = new Comode\syntax\Argument($this->predicateFactory, $this->questionFactory, $this->complimentFactory, $this->node);
        
        $predicate = $this->getMockBuilder('Comode\syntax\IPredicate')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->predicateFactory->expects($this->once())
                                ->method('providePredicatesByArgument')
                                ->with($this->node)
                                ->willReturn([$predicate]);
        
        $argumentPredicate = $argument->providePredicate();
        
        $this->assertInstanceOf('Comode\syntax\IPredicate', $argumentPredicate);
        
        $this->assertEquals($predicate, $argumentPredicate);
    }
    
    /**
     * @expectedException Comode\syntax\exception\PredicateAndQuestionHaveOneCommonArgument
     */
    public function testItPanicsWhenNoPredicate()
    {
        $argument = new Comode\syntax\Argument($this->predicateFactory, $this->questionFactory, $this->complimentFactory, $this->node);

        $this->predicateFactory->expects($this->once())
                                ->method('providePredicatesByArgument')
                                ->with($this->node)
                                ->willReturn([]);
        
        $argumentPredicate = $argument->providePredicate();
    }
    
    /**
     * @expectedException Comode\syntax\exception\PredicateAndQuestionHaveOneCommonArgument
     */
    public function testItPanicsWhenTooManyPredicates()
    {
        $argument = new Comode\syntax\Argument($this->predicateFactory, $this->questionFactory, $this->complimentFactory, $this->node);

        $predicate_1 = $this->getMockBuilder('Comode\syntax\IPredicate')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $predicate_2 = $this->getMockBuilder('Comode\syntax\IPredicate')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->predicateFactory->expects($this->once())
                                ->method('providePredicatesByArgument')
                                ->with($this->node)
                                ->willReturn([$predicate_1, $predicate_2]);
        
        $argumentPredicate = $argument->providePredicate();
    }
    
    public function testItProvidesComplimentByAnswer()
    {
        $argument = new Comode\syntax\Argument($this->predicateFactory, $this->questionFactory, $this->complimentFactory, $this->node);
        
        $answer = $this->getMockBuilder('Comode\syntax\IAnswer')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $compliment = $this->getMockBuilder('Comode\syntax\ICompliment')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $this->complimentFactory->expects($this->once())
                    ->method('provideComplimentsByArgument')
                    ->with($this->node)
                    ->willReturn([$compliment]); 

        $compliment->expects($this->once())
                    ->method('provideAnswer')
                    ->willReturn($answer);

        $answer->expects($this->any())
                    ->method('getId')
                    ->willReturn(5777123);
        
        $compliment = $argument->provideComplimentByAnswer($answer);
        
        $this->assertInstanceOf('Comode\syntax\ICompliment', $compliment);
    }
    
    /**
     * @expectedException Comode\syntax\exception\ArgumentAndAnswerHaveOneCommonCompliment
     */
    public function testItPanicsWhenNoComplimentForAnswer()
    {
        $argument = new Comode\syntax\Argument($this->predicateFactory, $this->questionFactory, $this->complimentFactory, $this->node);
        
        $answer = $this->getMockBuilder('Comode\syntax\IAnswer')
                            ->disableOriginalConstructor()
                            ->getMock();
                  
        $this->complimentFactory->expects($this->once())
                    ->method('provideComplimentsByArgument')
                    ->with($this->node)
                    ->willReturn([]); 

        $compliment = $argument->provideComplimentByAnswer($answer);
    }
}