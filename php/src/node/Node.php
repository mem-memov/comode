<?php
namespace Comode\node;

use Comode\node\store\IStore;
use Comode\node\value\IValue;

class Node implements INode
{
    private $store;
    private $valueFactory;
    private $id;
    private $value;
    
    /**
     * It creates node instances.
     * 
     * Some nodes have values bound to them, but most nodes have no value.
     *  - In order to create a new node with no value all parameters should be set to null.
     *  - For a new node that has a value attached pass null for $id, 
     * specify whether the value is a file or not and pass the path or text as the value content.
     *  - To retrieve an existing node by its id just pass the id
     */
    public function __construct(IStore $store, IValueFactory $valueFactory, $id = null, $isFile = null, $content = null)
    {
        $this->store = $store;
        $this->valueFactory = $valueFactory;
        
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
        $this->store->linkNodes($this->id, $node->getId());
    }
        
    public function getChildNodes()
    {
        return $this->store->getChildNodes($this->id);
        
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
