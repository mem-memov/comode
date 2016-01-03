<?php
namespace Comode\syntax\node;

use Comode\graph\IFactory as IGraphFactory;
use Comode\syntax\node\type\exception\NodeHasNoType;

class Factory implements IFactory
{
    private static $word = 'word';
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
    
    public function createWordNode($value)
    {
        $class = __NAMESPACE__ . '\\'. ucfirst(self::$word);
        $node = $this->graphFactory->makeNode(null, $value);
        $word = new $class($node);
        $this->checker->setType($word, self::$word);

        return $word;
    }
    
    public function getWordNodes(INode $node)
    {
        $class = __NAMESPACE__ . '\\'. ucfirst(self::$word);
        return $this->filter->byType($node, self::$word, $class);
    }
    
    public function createClauseNode()
    {
        $class = __NAMESPACE__ . '\\'. ucfirst(self::$clause);
        $node = $this->graphFactory->makeNode();
        $clause = new $class($node);
        $this->checker->setType($clause, self::$clause);

        return $clause;
    }
    
    public function fetchClauseNode($id)
    {
        $node = $this->graphFactory->makeNode($id);
        
        $class = __NAMESPACE__ . '\\'. ucfirst(self::$clause);
        $clause = new $class($node);

        if (!$this->checker->ofType($clause, self::$clause)) {
            throw new exception\NodeOfWrongType($id, self::$clause);
        }

        return $clause;
    }
    
    public function getClauseNodes(INode $node)
    {
        $class = __NAMESPACE__ . '\\'. ucfirst(self::$clause);
        return $this->filter->byType($node, self::$clause, $class);
    }
    
    public function createPredicateNode()
    {
        $class = __NAMESPACE__ . '\\'. ucfirst(self::$predicate);
        $node = $this->graphFactory->makeNode();
        $predicate = new $class($node);
        
        try {
            $type = $this->checker->getType($predicate);
            if ($type != self::$predicate) {
                
            }
        } catch (NodeHasNoType $exception) {
            $this->checker->setType($predicate, self::$predicate);
        }

        return $predicate;
    }
    
    public function getPredicateNodes(INode $node)
    {
        $class = __NAMESPACE__ . '\\'. ucfirst(self::$predicate);
        return $this->filter->byType($node, self::$predicate, $class);
    }
    
    public function createArgumentNode()
    {
        $class = __NAMESPACE__ . '\\'. ucfirst(self::$argument);
        $node = $this->graphFactory->makeNode();
        $argument = new $class($node);
        $this->checker->setType($argument, self::$argument);

        return $argument;
    }
    
    public function getArgumentNodes(INode $node)
    {
        $class = __NAMESPACE__ . '\\'. ucfirst(self::$argument);
        return $this->filter->byType($node, self::$argument, $class);
    }
    
    public function createQuestionNode()
    {
        $class = __NAMESPACE__ . '\\'. ucfirst(self::$question);
        $node = $this->graphFactory->makeNode();
        $question = new $class($node);
        $this->checker->setType($question, self::$question);

        return $question;
    }
    
    public function getQuestionNodes(INode $node)
    {
        $class = __NAMESPACE__ . '\\'. ucfirst(self::$question);
        return $this->filter->byType($node, self::$question, $class);
    }
    
    public function createComplimentNode()
    {
        $class = __NAMESPACE__ . '\\'. ucfirst(self::$compliment);
        $node = $this->graphFactory->makeNode();
        $compliment = new $class($node);
        $this->checker->setType($compliment, self::$compliment);

        return $compliment;
    }

    public function getComplimentNodes(INode $node)
    {
        $class = __NAMESPACE__ . '\\'. ucfirst(self::$compliment);
        return $this->filter->byType($node, self::$compliment, $class);
    }
    
    public function getComplimentSequence(INode $node)
    {
        $class = __NAMESPACE__ . '\\'. ucfirst(self::$compliment);
        return $this->sequenceFactory->getComplimentSequence($node, self::$compliment, $class);
    }

    public function createAnswerNode()
    {
        $class = __NAMESPACE__ . '\\'. ucfirst(self::$answer);
        $node = $this->graphFactory->makeNode();
        $answer = new $class($node);
        $this->checker->setType($answer, self::$answer);

        return $answer;
    }

    public function getAnswerNodes(INode $node)
    {
        $class = __NAMESPACE__ . '\\'. ucfirst(self::$answer);
        return $this->filter->byType($node, self::$answer, $class);
    }
}