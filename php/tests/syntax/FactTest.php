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
        $factFactory = new FactFactory($graphFactory, $questionFactory, $answerFactory);
        
        $statementNode = $graphFactory->createNode();
        $this->fact = $factFactory->createFact($statementNode);
    }
    
    protected function tearDown()
    {
        $this->graphFixture->tearDown();
    }

    public function testItsAnswerCanBeSetAsAString()
    {
        $stringAnswer = $this->fact->setStringAnswer('who');
        
        $this->assertInstanceOf('Comode\syntax\IAnswer', $stringAnswer);
    }
    
    public function testItsAnswerCanBeSetAsAFile()
    {
        $path = $this->graphFixture->createFile();
        
        $fileAnswer = $this->fact->setFileAnswer($path);
        
        $this->assertInstanceOf('Comode\syntax\IAnswer', $fileAnswer);
    }
}