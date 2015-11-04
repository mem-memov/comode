<?php
namespace Comode\syntax;

class QuestionFactory implements IQuestionFactory
{
    private $nodeFactory;
    private $argumentFactory;
    
    public function __construct(
        node\IFactory $nodeFactory
    ) {
        $this->nodeFactory = $nodeFactory;
    }
    
    public function setArgumentFactory(IArgumentFactory $argumentFactory)
    {
        $this->argumentFactory = $argumentFactory;
    }
    
    public function provideQuestion($string)
    {
        $questionNode = $this->nodeFactory->createQuestionNode($string);

        $question = $this->makeQuestion($questionNode);
        
        return $question;
    }
    
    public function provideQuestionsByArgument(node\IArgument $argumentNode)
    {
        $questionNodes = $this->nodeFactory->getQuestionNodes($argumentNode);
        
        $questions = [];
        
        foreach ($questionNodes as $questionNode) {
            $questions[] = $this->makeQuestion($questionNode);
        }
        
        return $questions;
    }
    
    private function makeQuestion(node\IQuestion $questionNode)
    {
        return new Question($this->argumentFactory, $questionNode);
    }
}