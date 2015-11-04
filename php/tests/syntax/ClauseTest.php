<?php
namespace Comode\syntax;
class ClauseTest extends \PHPUnit_Framework_TestCase
{/*
    protected function setUp()
    {
        require_once __DIR__ . '/../SyntaxFactoryFixture.php';
        $this->syntaxFactoryFixture = new \SyntaxFactoryFixture();
        $this->syntaxFactoryFixture->setUp();
        
        $this->clauseFactory = $this->syntaxFactoryFixture->clauseFactory;
    }
    
    protected function tearDown()
    {
        $this->syntaxFactoryFixture->tearDown();
    }

    public function testItGetsAPredicate()
    {
        $clause = $this->clauseFactory->createClause();
        
        $predicateString = 'make';
        
        $predicate = $clause->setPredicate($predicateString);
        
        $this->assertInstanceOf('Comode\syntax\IPredicate', $predicate);
    }
    
    public function testItKeepsItsPredicate()
    {
        $clause = $this->clauseFactory->createClause();
        
        $predicateString = 'make';
        
        $clause->setPredicate($predicateString);
        
        $predicate = $clause->getPredicate();
        
        $this->assertEquals($predicateString, $predicate->getValue());
    }
    
    public function testItGetsArguments()
    {
        $clause = $this->clauseFactory->createClause();
        
        $questionStrings = ['who', 'what', 'where'];
        
        $predicateString = 'make';
        
        $predicate = $clause->setPredicate($predicateString);
        
        $arguments = [];
        
        foreach ($questionStrings as $questionString) {
            $arguments[] = $clause->addArgument($questionString);
        }
        
        foreach ($arguments as $argument) {
            $this->assertInstanceOf('Comode\syntax\IArgument', $argument);
        }
    }
    
    public function testItKeepsItsArguments()
    {
        $clause = $this->clauseFactory->createClause();
        
        $questionStrings = ['who', 'what', 'where'];
        
        $predicateString = 'make';
        
        $predicate = $clause->setPredicate($predicateString);

        foreach ($questionStrings as $questionString) {
            $clause->addArgument($questionString);
        }
        
        $arguments = $clause->getArguments();
        
        $this->assertEquals(count($questionStrings), count($arguments));
    }
*/}