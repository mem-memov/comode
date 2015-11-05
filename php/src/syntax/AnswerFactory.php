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
    
    public function provideStringAnswer($string)
    {
        $stringAnswerNode = $this->nodeFactory->createStringAnswerNode($string);

        return $this->makeStringAnswer($stringAnswerNode);
    }
    
    public function provideFileAnswer($path)
    {
        $fileAnswerNode = $this->nodeFactory->createFileAnswerNode($path);

        return $this->makeFileAnswer($fileAnswerNode);
    }
    
    public function provideAnswersByCompliment(node\ICompliment $complimentNode)
    {
        $answerNodes = $this->nodeFactory->getAnswerNodes($complimentNode);
        
        $answers = [];
        
        foreach ($answerNodes as $answerNode) {
            if ($answerNode instanceof node\IStringAnswer) {
                $answers[] = $this->makeStringAnswer($answerNode);
            } elseif ($answerNode instanceof node\IFileAnswer) {
                $answers[] = $this->makeFileAnswer($answerNode);
            } else {
                throw new exception\NodeType('Unexpected answer node type: ' . gettype($answerNode));
            }
        }
        
        return $answers;
    }
    
    private function makeStringAnswer(node\IStringAnswer $stringAnswerNode)
    {
        return new StringAnswer($this->complimentFactory, $stringAnswerNode);
    }
    
    private function makeFileAnswer(node\IFileAnswer $fileAnswerNode)
    {
        return new FileAnswer($this->complimentFactory, $fileAnswerNode);
    }
}