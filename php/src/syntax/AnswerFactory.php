<?php
namespace Comode\syntax;

class AnswerFactory implements IAnswerFactory
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
    
    public function provideAnswer(array $structure)
    {
        $answerNode = $this->nodeFactory->createAnswerNode($structure);

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