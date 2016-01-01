<?php
namespace Comode\syntax\node;

use Comode\graph\IFactory as IGraphFactory;

class Factory implements IFactory
{
    private static $clause = 'clause';
    private static $predicate = 'predicate';
    private static $argument = 'argument';
    private static $question = 'question';
    private static $compliment = 'compliment';
    private static $answer = 'answer';

    private $graphFactory;
    private $checker;
    private $filter;
    private $sequenceFactory;
    
    public function __construct(
        IGraphFactory $graphFactory, 
        type\IChecker $checker, 
        type\IFilter $filter, 
        sequence\IFactory $sequenceFactory
    ) {
        $this->graphFactory = $graphFactory;
        $this->checker = $checker;
        $this->filter = $filter;
        $this->sequenceFactory = $sequenceFactory;
    }
    
    public function createClauseNode()
    {
        $node = $this->graphFactory->makeNode();
        $clause = new Clause($node);
        $this->checker->setType($clause, self::$clause);

        return $clause;
    }
    
    public function fetchClauseNode($id)
    {
        $node = $this->graphFactory->makeNode($id);
        
        $clause = new Clause($node);

        if (!$this->checker->ofType($clause, self::$clause)) {
            throw new exception\NodeOfWrongType($id, self::$clause);
        }

        return $clause;
    }
    
    public function getClauseNodes(INode $node)
    {
        $nodes = $this->filter->byType($node, self::$clause);
        
        $clauses = [];
        foreach ($nodes as $node) {
            $clauses[] = new Clause($node);
        }
        return $clauses;
    }
    
    public function createPredicateNode($value)
    {
        $node = $this->graphFactory->makeNode(null, $value);
        $predicate = new Predicate($node);
        $this->checker->setType($predicate, self::$predicate);

        return $predicate;
    }
    
    public function getPredicateNodes(INode $node)
    {
        $nodes = $this->filter->byType($node, self::$predicate);
        
        $predicates = [];
        foreach ($nodes as $node) {
            $predicates[] = new Predicate($node);
        }
        return $predicates;
    }
    
    public function createArgumentNode()
    {
        $node = $this->graphFactory->makeNode();
        $argument = new Argument($node);
        $this->checker->setType($argument, self::$argument);

        return $argument;
    }
    
    public function getArgumentNodes(INode $node)
    {
        $nodes = $this->filter->byType($node, self::$argument);
        
        $arguments = [];
        foreach ($nodes as $node) {
            $arguments[] = new Argument($node);
        }
        return $arguments;
    }
    
    public function createQuestionNode($value)
    {
        $node = $this->graphFactory->makeNode(null, $value);
        $question = new Question($node);
        $this->checker->setType($question, self::$question);

        return $question;
    }
    
    public function getQuestionNodes(INode $node)
    {
        $nodes = $this->filter->byType($node, self::$question);
        
        $questions = [];
        foreach ($nodes as $node) {
            $questions[] = new Question($node);
        }
        return $questions;
    }
    
    public function createComplimentNode()
    {
        $node = $this->graphFactory->makeNode();
        $compliment = new Compliment($node);
        $this->checker->setType($compliment, self::$compliment);

        return $compliment;
    }

    public function getComplimentNodes(INode $node)
    {
        $nodes = $this->filter->byType($node, self::$compliment);
        
        $compliments = [];
        foreach ($nodes as $node) {
            $compliments[] = new Compliment($node);
        }
        return $compliments;
    }
    
    public function getComplimentSequence(INode $node)
    {
        return $this->sequenceFactory->getComplimentSequence($node, self::$compliment);
    }

    public function createAnswerNode($value)
    {
        $node = $this->graphFactory->makeNode(null, $value);
        $answer = new Answer($node);
        $this->checker->setType($answer, self::$answer);

        return $answer;
    }

    public function getAnswerNodes(INode $node)
    {
        $nodes = $this->filter->byType($node, self::$answer);
        
        $answers = [];
        foreach ($nodes as $node) {
            $answers[] = new Answer($node);
        }
        return $answers;
    }
}