<?php
namespace Comode\graph;

use Comode\graph\store\IStore;

class Value implements IValue
{
    private $store;
    private $nodeFactory;
    private $isFile;
    private $content;
    
    public function __construct(IStore $store, INodeFactory $nodeFactory, $isFile, $content)
    {
        $this->store = $store;
        $this->nodeFactory = $nodeFactory;
        
        $storeValue = $this->store->getValue($isFile, $content);
        $this->isFile = $storeValue->isFile();
        $this->content = $storeValue->getContent();
    }
    
    public function getNode()
    {
        $id = $this->store->getValueNode(new store\Value($this->isFile, $this->content));
        
        if (is_null($id)) {
            return null;
        }
        
        $node = $this->nodeFactory->readNode($id);
        return $node;
    }
    
    public function isFile()
    {
        return $this->isFile;
    }
    
    public function getContent()
    {
        return $this->content;
    }
}