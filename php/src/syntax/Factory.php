<?php
namespace Comode\syntax;

use Comode\graph\IFactory as IGraphFactory;

class Factory implements IFactory
{
    private $clauseFactory;
    
    public function __construct(array $config, IGraphFactory $graphFactory)
    {
        $nodeFactory = new node\Factory($graphFactory, $config['spaceDirectory']);

        $this->questionFactory = new QuestionFactory($nodeFactory);
        $this->predicateFactory = new PredicateFactory($nodeFactory);
        $this->answerFactory = new AnswerFactory($nodeFactory);
        
        $this->argumentFactory = new ArgumentFactory($nodeFactory, $this->predicateFactory, $this->questionFactory);
        $this->questionFactory->setArgumentFactory($this->argumentFactory);
        $this->predicateFactory->setArgumentFactory($this->argumentFactory);
        
        $this->complimentFactory = new ComplimentFactory($nodeFactory, $this->argumentFactory, $this->answerFactory);
        $this->answerFactory->setComplimentFactory($this->complimentFactory);
        $this->argumentFactory->setComplimentFactory($this->complimentFactory);
        
        $this->clauseFactory = new ClauseFactory($nodeFactory, $this->complimentFactory);
        $this->complimentFactory->setClauseFactory($this->clauseFactory);
    }
    
    public function providePredicate(array $structure)
    {
        return $this->predicateFactory->providePredicate($structure);
    }
    
    public function provideQuestion(array $structure)
    {
        return $this->questionFactory->provideQuestion($structure);
    }
    
    public function provideArgument(IPredicate $predicate, IQuestion $question)
    {
        return $this->argumentFactory->provideArgument($predicate, $question);
    }
    
    public function provideAnswer(array $structure)
    {
        return $this->answerFactory->provideAnswer($structure);
    }

    public function provideCompliment(IArgument $argument, IAnswer $answer)
    {
        return $this->complimentFactory->provideCompliment($argument, $answer);
    }
    
    public function createClause(array $compliments)
    {
        return $this->clauseFactory->createClause($compliments);
    }

}