<?php
namespace Comode\syntax;
class PredicateTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        require_once __DIR__ . '/../SyntaxFactoryFixture.php';
        $this->syntaxFactoryFixture = new \SyntaxFactoryFixture();
        $this->syntaxFactoryFixture->setUp();

        $this->predicateFactory = $this->syntaxFactoryFixture->predicateFactory;
    }
    
    protected function tearDown()
    {
        $this->syntaxFactoryFixture->tearDown();
    }
    
    public function testItKeepsItsValue()
    {
        $predicateString = 'make';
        $predicate = $this->predicateFactory->providePredicate($predicateString);
        
        $this->assertEquals($predicate->getValue(), $predicateString);
    }
}