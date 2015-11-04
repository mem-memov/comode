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
        $node = $this->nodeFactory->createStringAnswerNode($string);

        return new StringAnswer($answerNode);
    }
    
    public function provideFileAnswer($path)
    {
        $node = $this->nodeFactory->createFileAnswerNode($path);

        return new FileAnswer($this->complimentFactory, $node);
    }
    

    
}