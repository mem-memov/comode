<?php
namespace Comode\syntax;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

class FactFactory implements IFactFactory
{
    private $graphFactory;
    private $questionFactory;
    private $answerFactory;
    private $spaceMap;
    
    public function __construct(IGraphFactory $graphFactory, IQuestionFactory $questionFactory, IAnswerFactory $answerFactory, ISpaceMap $spaceMap)
    {
        $this->graphFactory = $graphFactory;
        $this->questionFactory = $questionFactory;
        $this->answerFactory = $answerFactory;
        $this->spaceMap = $spaceMap;
    }
    
    public function createFact(INode $statementNode)
    {
        $fact = new Fact($this->graphFactory, $this->questionFactory, $this->answerFactory, $statementNode);
        
        return $fact;
    }
}