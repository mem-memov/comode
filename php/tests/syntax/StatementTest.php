<?php
namespace Comode\syntax;
class StatementTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        require_once('GraphFixture.php');
        $this->graphFixture = new \GraphFixture();
        $graphFactory = $this->graphFixture->setUp();
        
        $this->factory = new Factory($graphFactory);
    }
    
    protected function tearDown()
    {
        $this->graphFixture->tearDown();
    }

    public function testFactsCanBeAddedToIt()
    {
        $statement = $this->factory->createStatement();
        $fact_1 = $statement->addFact();
        $fact_2 = $statement->addFact();
        
        $this->assertInstanceOf('Comode\syntax\IFact', $fact_1);
        $this->assertInstanceOf('Comode\syntax\IFact', $fact_2);
    }
}
    