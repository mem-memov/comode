<?php
namespace Comode\syntax;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

class FactFactory implements IFactFactory
{
    private $graphFactory;
    private $questionFactory;
    private $answerFactory;
    
    public function __construct(IGraphFactory $graphFactory, IQuestionFactory $questionFactory, IAnswerFactory $answerFactory)
    {
        $this->graphFactory = $graphFactory;
        $this->questionFactory = $questionFactory;
        $this->answerFactory = $answerFactory;
    }
    
    public function createFact(INode $statementNode)
    {
        $factNode = $this->graphFactory->createNode();
        
        $factNode->addNode($statementNode);
        $statementNode->addNode($factNode);
        
        $fact = new Fact($this->questionFactory, $this->answerFactory, $factNode);
        
        return $fact;
    }
}