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

        $this->fileDirectory = $this->directoryFixture->createDirectory();

        $this->spaceDirectory = $this->directoryFixture->createDirectory();
        
        $config = [
            'spaceDirectory' => $this->spaceDirectory,
        ];
        $this->factory = new Factory($config, $graphFactory);
    }
    
    protected function tearDown()
    {
        $this->graphFixture->tearDown();
        $this->directoryFixture->removeDirectories();
    }
    
    public function testItProvidesPredicates()
    {
        $predicate = $this->factory->providePredicate('make');
        
        $this->assertInstanceOf('Comode\syntax\IPredicate', $predicate);
    }

    public function testItProvidesQuestions()
    {
        $question = $this->factory->provideQuestion('when');
        
        $this->assertInstanceOf('Comode\syntax\IQuestion', $question);
    }

    public function testItProvidesArguments()
    {
        $predicate = $this->factory->providePredicate('make');
        
        $question = $this->factory->provideQuestion('when');
        
        $argument = $this->factory->provideArgument($predicate, $question);
        
        $this->assertInstanceOf('Comode\syntax\IArgument', $argument);
    }
    
    public function testItProvidesStringAnswer()
    {
        $answer = $this->factory->provideStringAnswer('today');
        
        $this->assertInstanceOf('Comode\syntax\IAnswer', $answer);
    }

    public function testItProvidesFileAnswer()
    {
        $path = $this->fileDirectory . '/test.txt';
        
        file_put_contents($path, 'some content');
        
        $answer = $this->factory->provideFileAnswer($path);
        
        $this->assertInstanceOf('Comode\syntax\IAnswer', $answer);
    }
    
    public function testItProvidesCompliment()
    {
        $predicate = $this->factory->providePredicate('make');
        
        $question = $this->factory->provideQuestion('when');
        
        $argument = $this->factory->provideArgument($predicate, $question);
        
        $answer = $this->factory->provideStringAnswer('today');
        
        $compliment = $this->factory->provideCompliment($argument, $answer);
        
        $this->assertInstanceOf('Comode\syntax\ICompliment', $compliment);
    }

    public function testItCreatesClauses()
    {
        $predicate = $this->factory->providePredicate('make');
        
        $question = $this->factory->provideQuestion('when');
        
        $argument = $this->factory->provideArgument($predicate, $question);
        
        $answer = $this->factory->provideStringAnswer('today');
        
        $compliment = $this->factory->provideCompliment($argument, $answer);
        
        $clause = $this->factory->createClause([$compliment]);
        
        $this->assertInstanceOf('Comode\syntax\IClause', $clause);
    }
}