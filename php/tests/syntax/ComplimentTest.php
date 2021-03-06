<?php
namespace Comode\syntax;

class ComplimentTest extends \PHPUnit_Framework_TestCase
{
    protected $node;
    protected $clauseFactory;
    protected $argumentFactory;
    protected $answerFactory;
    
    protected function setUp()
    {
        $this->node = $this->getMockBuilder('Comode\syntax\node\ICompliment')
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
    
    public function testItSuppliesId()
    {
        $compliment = new Compliment($this->clauseFactory, $this->argumentFactory, $this->answerFactory, $this->node);
        
        $id = 7773;
        
        $this->node->expects($this->once())
                        ->method('getId')
                        ->willReturn($id);
                        
        $complimentId = $compliment->getId();
        
        $this->assertEquals($complimentId, $id);
    }
    
    public function testItGetsLinkedToClauses()
    {
        $compliment = new Compliment($this->clauseFactory, $this->argumentFactory, $this->answerFactory, $this->node);
        
        $complimentSequence = $this->getMockBuilder('Comode\syntax\node\sequence\ICompliment')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $complimentSequence->expects($this->once())
                    ->method('append')
                    ->with($this->node);

        $compliment->addClause($complimentSequence);
    }
    
    public function testItFetchesClauses()
    {
        $compliment = new Compliment($this->clauseFactory, $this->argumentFactory, $this->answerFactory, $this->node);
        
        $clause = $this->getMockBuilder('Comode\syntax\IClause')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->clauseFactory->expects($this->once())
                        ->method('fetchClausesByCompliment')
                        ->with($this->node)
                        ->willReturn([$clause]);
        
        $clauses = $compliment->fetchClauses();
        
        $this->assertContainsOnlyInstancesOf('Comode\syntax\IClause', $clauses);
    }
    
    public function testItProvidesArgument()
    {
        $compliment = new Compliment($this->clauseFactory, $this->argumentFactory, $this->answerFactory, $this->node);
        
        $argument = $this->getMockBuilder('Comode\syntax\IArgument')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->argumentFactory->expects($this->once())
                                ->method('provideArgumentsByCompliment')
                                ->with($this->node)
                                ->willReturn([$argument]);
        
        $complimentArgument = $compliment->provideArgument();
        
        $this->assertInstanceOf('Comode\syntax\IArgument', $complimentArgument);
        
        $this->assertEquals($argument, $complimentArgument);
    }
    
    /**
     * @expectedException Comode\syntax\exception\ArgumentAndAnswerHaveOneCommonCompliment
     */
    public function testItPanicsWhenNoArgument()
    {
        $compliment = new Compliment($this->clauseFactory, $this->argumentFactory, $this->answerFactory, $this->node);

        $this->argumentFactory->expects($this->once())
                                ->method('provideArgumentsByCompliment')
                                ->with($this->node)
                                ->willReturn([]);
        
        $complimentArgument = $compliment->provideArgument();
    }
    
    /**
     * @expectedException Comode\syntax\exception\ArgumentAndAnswerHaveOneCommonCompliment
     */
    public function testItPanicsWhenTooManyArguments()
    {
        $compliment = new Compliment($this->clauseFactory, $this->argumentFactory, $this->answerFactory, $this->node);

        $argument_1 = $this->getMockBuilder('Comode\syntax\IArgument')
                            ->disableOriginalConstructor()
                            ->getMock();
                            
        $argument_2 = $this->getMockBuilder('Comode\syntax\IArgument')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->argumentFactory->expects($this->once())
                                ->method('provideArgumentsByCompliment')
                                ->with($this->node)
                                ->willReturn([$argument_1, $argument_2]);
        
        $complimentArgument = $compliment->provideArgument();
    }
    
    public function testItProvidesAnswer()
    {
        $compliment = new Compliment($this->clauseFactory, $this->argumentFactory, $this->answerFactory, $this->node);
        
        $answer = $this->getMockBuilder('Comode\syntax\IAnswer')
                            ->disableOriginalConstructor()
                            ->getMock();
        
        $this->answerFactory->expects($this->once())
                                ->method('provideAnswersByCompliment')
                                ->with($this->node)
                                ->willReturn([$answer]);
        
        $complimentAnswer = $compliment->provideAnswer();
        
        $this->assertInstanceOf('Comode\syntax\IAnswer', $complimentAnswer);
        
        $this->assertEquals($answer, $complimentAnswer);
    }
    
    /**
     * @expectedException Comode\syntax\exception\ArgumentAndAnswerHaveOneCommonCompliment
     */
    public function testItPanicsWhenNoAnswer()
    {
        $compliment = new Compliment($this->clauseFactory, $this->argumentFactory, $this->answerFactory, $this->node);

        $this->answerFactory->expects($this->once())
                                ->method('provideAnswersByCompliment')
                                ->with($this->node)
                                ->willReturn([]);
        
        $complimentAnswer = $compliment->provideAnswer();
    }
    
    /**
     * @expectedException Comode\syntax\exception\ArgumentAndAnswerHaveOneCommonCompliment
     */
    public function testItPanicsWhenTooManyAnswers()
    {
        $compliment = new Compliment($this->clauseFactory, $this->argumentFactory, $this->answerFactory, $this->node);

        $answer_1 = $this->getMockBuilder('Comode\syntax\IAnswer')
                            ->disableOriginalConstructor()
                            ->getMock();;
                            
        $answer_2 = $this->getMockBuilder('Comode\syntax\IAnswer')
                            ->disableOriginalConstructor()
                            ->getMock();;
        
        $this->answerFactory->expects($this->once())
                                ->method('provideAnswersByCompliment')
                                ->with($this->node)
                                ->willReturn([$answer_1, $answer_2]);
        
        $complimentAnswer = $compliment->provideAnswer();
    }
}