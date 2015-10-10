<?php
namespace Comode\syntax;
class QuestionTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        require_once('GraphFixture.php');
        $this->graphFixture = new \GraphFixture();
        $graphFactory = $this->graphFixture->setUp();
        
        $this->questionFactory = new QuestionFactory($graphFactory);
    }
    
    protected function tearDown()
    {
        $this->graphFixture->tearDown();
    }


}