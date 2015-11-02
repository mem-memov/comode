<?php
namespace Comode\syntax;
class FactoryTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        require_once __DIR__ . '/../GraphFixture.php';
        $this->graphFixture = new \GraphFixture();
        $graphFactory = $this->graphFixture->setUp();

        require_once __DIR__ . '/../DirectoryFixture.php';
        $this->directoryFixture = new \DirectoryFixture();

        $this->spaceDirectory = $this->directoryFixture->createDirectory();
        
        $config = [
            'spaceDirectory' => $this->spaceDirectory,
        ];
        $this->factory = new Factory($config, $graphFactory);
    }
    
    protected function tearDown()
    {
        $this->graphFixture->tearDown();
        $this->directoryFixture->removeDirectory();
    }

    public function testItCreatesClauses()
    {
        $clause = $this->factory->createClause();
        
        $this->assertInstanceOf('Comode\syntax\IClause', $clause);
    }
}