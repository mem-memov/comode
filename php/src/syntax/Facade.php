<?php
namespace Comode\syntax;

use Comode\graph\Facade as GraphFactory;

final class Facade extends Factory
{
    public function __construct(array $config)
    {
        $graphFactory = new GraphFactory($config['graph']);
        $nodeFactory = new node\Facade($graphFactory, $config['syntax']['spaceDirectory']);

        $wordFactory = new WordFactory($nodeFactory);
        
        $questionFactory = new QuestionFactory($nodeFactory, $wordFactory);
        $wordFactory->setQuestionFactory($questionFactory);
        
        $predicateFactory = new PredicateFactory($nodeFactory, $wordFactory);
        $wordFactory->setPredicateFactory($predicateFactory);
        
        $answerFactory = new AnswerFactory($nodeFactory, $wordFactory);
        $wordFactory->setAnswerFactory($answerFactory);
        
        $argumentFactory = new ArgumentFactory($nodeFactory, $predicateFactory, $questionFactory);
        $questionFactory->setArgumentFactory($argumentFactory);
        $predicateFactory->setArgumentFactory($argumentFactory);
        
        $complimentFactory = new ComplimentFactory($nodeFactory, $argumentFactory, $answerFactory);
        $answerFactory->setComplimentFactory($complimentFactory);
        $argumentFactory->setComplimentFactory($complimentFactory);
        
        $clauseFactory = new ClauseFactory($nodeFactory, $complimentFactory);
        $complimentFactory->setClauseFactory($clauseFactory);

        parent::__construct(
            $wordFactory, 
            $argumentFactory, 
            $complimentFactory, 
            $clauseFactory
        );
    }
}