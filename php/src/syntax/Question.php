<?php
namespace Comode\syntax;

final class Question implements IQuestion
{
    private $wordFactory;
    private $argumentFactory;
    private $node;

    public function __construct(
        IWordFactory $wordFactory,
        IArgumentFactory $argumentFactory,
        node\IQuestion $node
    ) {
        $this->wordFactory = $wordFactory;
        $this->argumentFactory = $argumentFactory;
        $this->node = $node;
    }
    
    public function getId()
    {
        return $this->node->getId();
    }
    
    public function provideWord()
    {
        return $this->wordFactory->provideWordByQuestion($this->node);
    }
    
    public function addArgument(node\IArgument $argumentNode)
    {
        $argumentNode->addNode($this->node);
        $this->node->addNode($argumentNode);
    }

    public function provideArguments()
    {
        return $this->argumentFactory->provideArgumentsByQuestion($this->node);
    }

}