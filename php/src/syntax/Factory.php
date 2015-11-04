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
        
        $this->clauseFactory = new ClauseFactory($nodeFactory, $this->predicateFactory, $this->complimentFactory);
        $this->complimentFactory->setClauseFactory($this->clauseFactory);
    }
    
    public function providePredicate($verb)
    {
        return $this->predicateFactory->providePredicate($verb);
    }
    
    public function provideQuestion($question)
    {
        return $this->questionFactory->provideQuestion($question);
    }
    
    public function provideArgument(IPredicate $predicate, IQiestion $question)
    {
        return $this->argumentFactory->provideArgument($predicate, $question);
    }
    
    public function provideStringAnswer($phrase)
    {
        return $this->answerFactory->provideStringAnswer($phrase);
    }
    
    public function provideFileAnswer($path)
    {
        return $this->answerFactory->provideFileAnswer($path);
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