<?php
namespace Comode\syntax;

use Comode\graph\INode;

class Question implements IQuestion
{
    private $node;

    public function __construct(INode $node)
    {
        $this->node = $node;
    }
    
    public function provideArgument(IArgumentProvider $argumentProvider)
    {
        $argumentProvider->setQuestionNode($this->node);
    }

}