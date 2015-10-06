<?php
namespace Comode\node;

use Comode\node\store\IStore;
use Comode\node\value\IValue;

class Node implements INode
{
    private $store;
    private $id;
    private $value;
    
    public function __construct(
        IStore $store,
        $id = null,
        IValue $value = null
    ) {
        $this->store = $store;
        
        if (is_null($id)) {
            $id = $this->store->createNode($value);
        } else {
            if (!$this->store->nodeExists($id)) {
                throw new NoIdWhenRetrievingNode();
            }
        }
        
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function addNode(INode $node)
    {
        $this->store->linkIds($this->id, $node->getId());
    }
        
    public function getChildNodes()
    {
        return $this->store->getChildIds($this->id);
        
        $store = $this->makeStore();
        
        $childIds = $store->getChildNodes($node->getId());
        
        $childNodes = [];
        
        foreach ($childIds as $childId) {
            $childNode = $this->makeNode($childId);
            array_push($childNodes, $childNode);
        }
        
        return $childNodes;
    }
        
    public function getValue()
    {
        return $this->store->getValue($this->id);
    }
}
