<?php
namespace Comode\syntax;

final class Clause implements IClause
{
    private $complimentFactory;
    private $node;

    public function __construct(
        IComplimentFactory $complimentFactory,
        node\IClause $node
    )
    {
        $this->complimentFactory = $complimentFactory;
        $this->node = $node;
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
        $arguments = $this->complimentFactory->provideComplimentsByClause($this->node);
        
        return $arguments;
    }
}