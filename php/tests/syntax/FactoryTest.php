<?php
namespace Comode\syntax;
class FactoryTest extends \PHPUnit_Framework_TestCase
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

    public function testItCreatesStatements()
    {
        $statement = $this->factory->createStatement();
        
        $this->assertInstanceOf('Comode\syntax\IStatement', $statement);
    }
}