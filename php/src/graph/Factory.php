<?php
namespace Comode\graph;

class Factory implements IFactory
{
    private $nodeFactory;
    private $valueFactory;

    public function __construct(INodeFactory $nodeFactory, IValueFactory $valueFactory)
    {
        $this->nodeFactory = $nodeFactory;
        $this->valueFactory = $valueFactory;
    }

    public function createNode(array $structure = [])
    {
        return $this->nodeFactory->createNode($structure);
    }

    public function readNode($nodeId)
    {
         return $this->nodeFactory->readNode($nodeId);
    }

    public function makeValue(array $structure)
    {
        return $this->valueFactory->makeValue($structure);
    }
}
