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

    public function createNode()
    {
        return $this->nodeFactory->createNode();
    }

    public function createStringNode($content)
    {
         return $this->nodeFactory->createStringNode($content);
    }

    public function createFileNode($path)
    {
        return $this->nodeFactory->createFileNode($path);
    }

    public function readNode($nodeId)
    {
         return $this->nodeFactory->readNode($nodeId);
    }

    public function makeStringValue($content)
    {
        return $this->valueFactory->makeStringValue($content);
    }
    
    public function makeFileValue($path)
    {
        return $this->valueFactory->makeFileValue($path);
    }

}
