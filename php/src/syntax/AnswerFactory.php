<?php
namespace Comode\syntax;

final class AnswerFactory implements IAnswerFactory
{
    private $nodeFactory;
    private $wordFactory;
    private $complimentFactory;
    
    public function __construct(
        node\IFactory $nodeFactory,
        IWordFactory $wordFactory
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->wordFactory = $wordFactory;
    }
    
    public function setComplimentFactory(IComplimentFactory $complimentFactory)
    {
        $this->complimentFactory = $complimentFactory;
    }
    
    public function fetchAnswer($id)
    {
        $answerNode = $this->nodeFactory->fetchAnswerNode($id);
        return $this->makeAnswer($answerNode);
    }
    
    public function provideAnswerByWord(node\IWord $wordNode)
    {
        $answerNodes = $this->nodeFactory->getAnswerNodes($wordNode);
        
        $answerNodeCount = count($answerNodes);
        
        if ($answerNodeCount > 1) {
            throw new exception\WordMayHaveOneAnswer($wordNode, $answerNodeCount);
        }
        
        if ($answerNodeCount == 0) {
            $answerNode = $this->nodeFactory->createAnswerNode();
            $answerNode->addNode($wordNode);
            $wordNode->addNode($answerNode);
        } else {
            $answerNode = $answerNodes[0];
        }

        return $this->makeAnswer($answerNode);
    }

    public function provideAnswersByCompliment(node\ICompliment $complimentNode)
    {
        $answerNodes = $this->nodeFactory->getAnswerNodes($complimentNode);
        
        $answers = [];
        
        foreach ($answerNodes as $answerNode) {
            $answers[] = $this->makeAnswer($answerNode);
        }
        
        return $answers;
    }
    
    private function makeAnswer(node\IAnswer $answerNode)
    {
        return new Answer(
            $this->wordFactory, 
            $this->complimentFactory, 
            $answerNode
        );
    }
}