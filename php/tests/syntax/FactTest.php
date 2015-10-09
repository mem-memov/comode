<?php
namespace Comode\syntax;
class FactTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        require_once('GraphFixture.php');
        $this->graphFixture = new \GraphFixture();
        $graphFactory = $this->graphFixture->setUp();

        $questionFactory = new QuestionFactory($graphFactory);
        $answerFactory = new AnswerFactory($graphFactory);
        $this->factFactory = new FactFactory($graphFactory, $questionFactory, $answerFactory);
    }
    
    protected function tearDown()
    {
        $this->graphFixture->tearDown();
    }

    public function testItsAnswerCanBeSetAsAString()
    {
        $fact = $this->factFactory->createFact();
        
        $stringAnswer = $fact->setStringAnswer();
        
        $this->assertInstanceOf('Comode\syntax\IAnswer', $stringAnswer);
    }
    
    public function testItsAnswerCanBeSetAsAFile()
    {
        $fact = $this->factFactory->createFact();
        
        $fileAnswer = $fact->setFileAnswer();
        
        $this->assertInstanceOf('Comode\syntax\IAnswer', $fileAnswer);
    }
}