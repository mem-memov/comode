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
    
    public function provideQuestion($string)
    {
        $questionNode = $this->spaceMap->createQuestionNode($string);

        $question = $this->makeQuestion($questionNode);
        
        return $question;
    }
    
    public function provideQuestionsByPredicate(INode $predicateNode)
    {
        $questionNodes = $this->spaceMap->getQuestionNodes($predicateNode);
        
        $questions = [];
        
        foreach ($questionNodes as $questionNode) {
            $questions[] = $this->makeQuestion($questionNode);
        }
        
        return $questions;
    }
    
    private function makeQuestion(INode $questionNode)
    {
        return new Question($questionNode);
    }
}