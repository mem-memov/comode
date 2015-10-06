<?php
namespace Comode\node;

use Comode\node\store\IStore;

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
        $this->isFile = $isFile;
        $this->content = $content;
    }
    
    public function getNodes()
    {
        $ids = $this->store->getNodesByValue(new store\Value($this->isFile, $this->content));
        
        $nodes = [];
        
        foreach ($ids as $id) {
            $node = $this->makeNode($id);
            array_push($nodes, $node);
        }
        
        return $nodes;
    }
}