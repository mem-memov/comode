<?php
namespace Comode\syntax;
class ClauseTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        require_once __DIR__ . '/../GraphFixture.php';
        $this->graphFixture = new \GraphFixture();
        $graphFactory = $this->graphFixture->setUp();

        require_once __DIR__ . '/../DirectoryFixture.php';
        $this->directoryFixture = new \DirectoryFixture();

        $config = [
            'spaceDirectory' => $this->directoryFixture->createDirectory(),
        ];
        $factory = new Factory($config, $graphFactory);
        
        $this->clause = $factory->createClause();
    }
    
    protected function tearDown()
    {
        $this->graphFixture->tearDown();
        $this->directoryFixture->removeDirectory();
    }

    public function testItGetsAPredicate()
    {
        $predicateString = 'make';
        
        $predicate = $this->clause->setPredicate($predicateString);
        
        $this->assertInstanceOf('Comode\syntax\IPredicate', $predicate);
    }
    
    public function testItGetsArguments()
    {
        $questionStrings = ['who', 'what', 'where'];
        
        $predicateString = 'make';
        
        $predicate = $this->clause->setPredicate($predicateString);
        
        $arguments = [];
        
        foreach ($questionStrings as $questionString) {
            $arguments[] = $this->clause->addArgument($questionString);
        }
        
        foreach ($arguments as $argument) {
            $this->assertInstanceOf('Comode\syntax\IArgument', $argument);
        }
        
    }
}