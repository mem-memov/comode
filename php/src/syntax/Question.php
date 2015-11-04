<?php
namespace Comode\syntax;

use Comode\graph\INode;

class Question implements IQuestion
{
    private $argumentFactory;
    private $node;

    public function __construct(
        IArgumentFactory $argumentFactory,
        INode $node
    ) {
        $this->argumentFactory = $argumentFactory;
        $this->node = $node;
    }
    
    public function getId()
    {
        return $this->node->getId();
    }
    
    public function addArgument(node\IArgument $argumentNode)
    {
        $argumentNode->addNode($this->node);
        $this->node->addNode($argumentNode);
    }
    
    public function getValue()
    {
        return $this->node->getValue()->getContent();
    }
    
    public function provideArguments()
    {
        return $this->argumentFactory->provideArgumentsByQuestion($this->node);
    }

}