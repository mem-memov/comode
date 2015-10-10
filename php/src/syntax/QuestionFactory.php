<?php
namespace Comode\syntax;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

class QuestionFactory implements IQuestionFactory
{
    private $graphFactory;
    
    public function __construct(IGraphFactory $graphFactory)
    {
        $this->graphFactory = $graphFactory;
    }
    
    public function createQuestion($string, INode $factNode)
    {
        $questionNode = $this->graphFactory->createStringNode($string);
        
        $questionNode->addNode($factNode);
        $factNode->addNode($questionNode);
        
        $question = new Question($string, $questionNode);
        
        return $question;
    }
}