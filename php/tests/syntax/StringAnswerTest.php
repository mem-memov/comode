<?php
namespace Comode\syntax;
class StringAnswerTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        require_once('GraphFixture.php');
        $this->graphFixture = new \GraphFixture();
        $graphFactory = $this->graphFixture->setUp();
        
        $this->answerFactory = new AnswerFactory($graphFactory);
    }
    
    protected function tearDown()
    {
        $this->graphFixture->tearDown();
    }
    
    public function testItsValueCanBeSetWithAString()
    {
        $stringAnswer = $this->answerFactory->createStringAnswer();
        
        $stringAnswer->set('Mr. Obvious');
    }
}