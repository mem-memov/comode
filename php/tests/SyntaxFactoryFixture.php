<?php
namespace Comode\syntax;
class SyntaxFactoryFixture
{
    public function setUp()
    {
        require_once __DIR__ . '/GraphFixture.php';
        $this->graphFixture = new \GraphFixture();
        $graphFactory = $this->graphFixture->setUp();

        require_once __DIR__ . '/DirectoryFixture.php';
        $this->directoryFixture = new \DirectoryFixture();

        $spaceDirectory = $this->directoryFixture->createDirectory();
        
        $nodeFactory = new node\Factory($graphFactory, $spaceDirectory);
        
        $this->answerFactory = new AnswerFactory($nodeFactory);
        $this->complimentFactory = new ComplimentFactory($nodeFactory, $this->argumentFactory, $this->answerFactory);
        $this->questionFactory = new QuestionFactory($nodeFactory, $this->argumentFactory);
        $this->argumentFactory = new ArgumentFactory($nodeFactory, $this->questionFactory, $this->complimentFactory);
        $this->predicateFactory = new PredicateFactory($nodeFactory, $this->argumentFactory);
        $this->clauseFactory = new ClauseFactory($nodeFactory, $this->predicateFactory, $this->complimentFactory);
        
        $this->argumentFactory->setPredicateFactory($this->predicateFactory);
        $this->complimentFactory->setClauseFactory($this->clauseFactory);
    }
    
    public function tearDown()
    {
        $this->graphFixture->tearDown();
        $this->directoryFixture->removeDirectory();
    }
}