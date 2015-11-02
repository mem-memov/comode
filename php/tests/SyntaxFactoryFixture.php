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
        
        $spaceMap = new Comode\syntax\SpaceMap($graphFactory, $spaceDirectory);
        
        $complimentFactory = new Comode\syntax\ComplimentFactory($graphFactory, $spaceMap);
        $questionFactory = new Comode\syntax\QuestionFactory($graphFactory, $spaceMap);
        $argumentFactory = new Comode\syntax\ArgumentFactory($graphFactory, $spaceMap, $questionFactory, $complimentFactory);
        $predicateFactory = new Comode\syntax\PredicateFactory($graphFactory, $spaceMap, $argumentFactory);
        $argumentFactory->setPredicateFactory($predicateFactory);
        $clauseFactory = new Comode\syntax\ClauseFactory($graphFactory, $spaceMap, $predicateFactory, $argumentFactory, $questionFactory);
        $predicateFactory->setClauseFactory($clauseFactory);
        $argumentFactory->setClauseFactory($clauseFactory);
        
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