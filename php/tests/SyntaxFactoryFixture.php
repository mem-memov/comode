<?php

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
        
        $nodeFactory = new Comode\syntax\node\Factory($graphFactory, $spaceDirectory);
        
        $complimentFactory = new Comode\syntax\ComplimentFactory($graphFactory, $nodeFactory);
        $questionFactory = new Comode\syntax\QuestionFactory($graphFactory, $nodeFactory);
        $argumentFactory = new Comode\syntax\ArgumentFactory($graphFactory, $nodeFactory, $questionFactory, $complimentFactory);
        $predicateFactory = new Comode\syntax\PredicateFactory($graphFactory, $nodeFactory, $argumentFactory);
        $argumentFactory->setPredicateFactory($predicateFactory);
        $clauseFactory = new Comode\syntax\ClauseFactory($graphFactory, $nodeFactory, $predicateFactory, $argumentFactory, $questionFactory);
        $predicateFactory->setClauseFactory($clauseFactory);
        $argumentFactory->setClauseFactory($clauseFactory);
        
        $this->nodeFactory = $nodeFactory;
        $this->complimentFactory = $complimentFactory;
        $this->questionFactory = $questionFactory;
        $this->argumentFactory = $argumentFactory;
        $this->predicateFactory = $predicateFactory;
        $this->clauseFactory = $clauseFactory;
    }
    
    public function tearDown()
    {
        $this->graphFixture->tearDown();
        $this->directoryFixture->removeDirectory();
    }
}