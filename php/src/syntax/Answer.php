<?php
namespace Comode\syntax;

final class Answer implements IAnswer
{
    private $wordFactory;
    private $complimentFactory;
    private $node;

    public function __construct(
        IWordFactory $wordFactory,
        IComplimentFactory $complimentFactory, 
        node\IAnswer $node
    ) {
        $this->wordFactory = $wordFactory;
        $this->complimentFactory = $complimentFactory;
        $this->node = $node;
    }
    
    public function getId()
    {
        return $this->node->getId();
    }
    
    public function provideWord()
    {
        return $this->wordFactory->provideWordByAnswer($this->node);
    }
    
    public function addCompliment(node\ICompliment $complimentNode)
    {
        $complimentNode->addNode($this->node);
        $this->node->addNode($complimentNode);
    }
    
    public function provideCompliments()
    {
        return $this->complimentFactory->provideComplimentsByAnswer($this->node);
    }
}