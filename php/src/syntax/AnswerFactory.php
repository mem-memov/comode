<?php
namespace Comode\syntax;

final class AnswerFactory implements IAnswerFactory
{
    private $nodeFactory;
    private $complimentFactory;
    
    public function __construct(
        node\IFactory $nodeFactory
    ) {
        $this->nodeFactory = $nodeFactory;
    }
    
    public function setComplimentFactory(IComplimentFactory $complimentFactory)
    {
        $this->complimentFactory = $complimentFactory;
    }
    
    public function provideAnswer($value)
    {
        $answerNode = $this->nodeFactory->createAnswerNode($value);

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
        return new Answer($this->complimentFactory, $answerNode);
    }
}