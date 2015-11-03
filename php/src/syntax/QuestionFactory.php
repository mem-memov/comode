<?php
namespace Comode\syntax;

class QuestionFactory implements IQuestionFactory
{
    private $nodeFactory;
    
    public function __construct(
        node\IFactory $nodeFactory
    ) {
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