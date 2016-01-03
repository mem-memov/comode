<?php
namespace Comode\syntax;

final class QuestionFactory implements IQuestionFactory
{
    private $nodeFactory;
    private $wordFactory;
    private $argumentFactory;
    
    public function __construct(
        node\IFactory $nodeFactory,
        IWordFactory $wordFactory
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->wordFactory = $wordFactory;
    }
    
    public function setArgumentFactory(IArgumentFactory $argumentFactory)
    {
        $this->argumentFactory = $argumentFactory;
    }
    
    public function provideQuestionByWord(node\IWord $wordNode)
    {
        $questionNodes = $this->nodeFactory->getQuestionNodes($wordNode);
        
        $questionNodeCount = count($questionNodes);
        
        if ($questionNodeCount > 1) {
            throw new exception\WordMayHaveOneQuestion($wordNode, $questionNodeCount);
        }
        
        if ($questionNodeCount == 0) {
            $questionNode = $this->nodeFactory->createQuestionNode();
            $questionNode->addNode($wordNode);
            $wordNode->addNode($questionNode);
        } else {
            $questionNode = $questionNodes[0];
        }

        return $this->makeQuestion($questionNode);
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