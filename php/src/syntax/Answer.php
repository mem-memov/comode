<?php
namespace Comode\syntax;

final class Answer implements IAnswer
{
    private  $complimentFactory;
    private  $node;

    public function __construct(
        IComplimentFactory $complimentFactory, 
        node\IAnswer $node
    ) {
        $this->node = $node;
        $this->complimentFactory = $complimentFactory;
    }
    
    public function getId()
    {
        return $this->node->getId();
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

    public function getValue()
    {
        return $this->node->getValue();
    }
}