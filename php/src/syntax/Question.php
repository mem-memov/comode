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
    
    public function provideArgument(operation\IArgumentNodeProvider $argumentNodeProvider)
    {
        $argumentNodeProvider->setQuestionNode($this->node);
    }
    
    public function getValue()
    {
        return $this->node->getValue()->getContent();
    }

}