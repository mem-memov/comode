<?php
namespace Comode\syntax;

use Comode\graph\INode;
use Comode\graph\IFactory as IGraphFactory;

class QuestionFactory implements IQuestionFactory
{
    private $graphFactory;
    private $nodeFactory;
    
    public function __construct(
        IGraphFactory $graphFactory, 
        node\IFactory $nodeFactory
    ) {
        $this->graphFactory = $graphFactory;
        $this->nodeFactory = $nodeFactory;
    }
    
    public function provideQuestion($string)
    {
        $questionNode = $this->nodeFactory->createQuestionNode($string);

        $question = $this->makeQuestion($questionNode);
        
        return $question;
    }
    
    public function provideQuestionsByPredicate(node\IPredicate $predicateNode)
    {
        $questionNodes = $this->nodeFactory->getQuestionNodes($predicateNode);
        
        $questions = [];
        
        foreach ($questionNodes as $questionNode) {
            $questions[] = $this->makeQuestion($questionNode);
        }
        
        return $questions;
    }
    
    private function makeQuestion(node\IQuestion $questionNode)
    {
        return new Question($questionNode);
    }
}