<?php
namespace Comode\syntax\node;

use Comode\syntax\node\INode;

class Factory implements IFactory
{
    private static $clause = 'clause';
    private static $predicate = 'predicate';
    private static $argument = 'argument';
    private static $question = 'question';
    private static $compliment = 'compliment';
    private static $answer = 'answer';

    private $creator;
    private $filter;
    private $sequenceFactory;
    
    public function __construct(type\ICreator $creator, type\IFilter $filter, sequence\IFactory $sequenceFactory)
    {
        $this->creator = $creator;
        $this->filter = $filter;
        $this->sequenceFactory = $sequenceFactory;
    }
    
    public function createClauseNode()
    {
        $node = $this->creator->createNode(self::$clause);

        return new Clause($node);
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
        $node = $this->creator->createNode(self::$predicate, $value);

        return new Predicate($node);
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
        $node = $this->creator->createNode(self::$argument);

        return new Argument($node);
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
        $node = $this->creator->createNode(self::$question, $value);

        return new Question($node);
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
        $node = $this->creator->createNode(self::$compliment);

        return new Compliment($node);
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
        $node = $this->creator->createNode(self::$answer, $value);

        return new Answer($node);
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