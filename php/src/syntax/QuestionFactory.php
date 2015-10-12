<?php
namespace Comode\syntax;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

class QuestionFactory implements IQuestionFactory
{
    private $graphFactory;
    private $spaceMap;
    
    public function __construct(IGraphFactory $graphFactory, ISpaceMap $spaceMap)
    {
        $this->graphFactory = $graphFactory;
        $this->spaceMap = $spaceMap;
    }
    
    public function createQuestion($string)
    {
        $questionNode = $this->graphFactory->createStringNode($string);

        $question = new Question($string, $questionNode);
        
        return $question;
    }
}