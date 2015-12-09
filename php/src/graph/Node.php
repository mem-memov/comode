<?php
namespace Comode\graph;

use Comode\graph\store\IStore;
use Comode\graph\store\ValueNotFound;

class Node implements INode
{
    private $store;
    private $factory;
    private $id;

    /**
     * It creates node instances.
     * 
     * Some nodes have values bound to them, but most nodes have no value.
     *  - In order to create a new node with no value, id should be set to null and value should be set to an empty string.
     *  - For a new node that has a value attached pass null for id and a string value.
     *  - To retrieve an existing node by its id just pass the id
     * It's not possible to assign a value to an existing node.
     * A value can be assigned only when a node is created.
     */
    public function __construct(IStore $store, IFactory $factory, $id = null, $value = '')
    {
        if (!is_null($id) && strlen($value) > 0) {
            throw new exception\NodeValueIsConstant('Trying to reassign value of node ' . $id);
        }
        
        if (!is_null($id) && !$store->nodeExists($id)) {
            throw new exception\NodeHasAnId('Node ID ' . $id . ' is not known.');
        }

        if (is_null($id)) {
            $id = $store->createNode($value);
        }
        
        $this->store = $store;
        $this->factory = $factory;
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
    
    public function removeNode(INode $node)
    {
        $this->store->separateNodes($this->id, $node->getId());
    }
        
    public function getNodes()
    {
        $childIds = $this->store->getLinkedNodes($this->id);
        
        $childNodes = [];
        
        foreach ($childIds as $childId) {
            $childNode = $this->factory->makeNode($childId);
            array_push($childNodes, $childNode);
        }

        return $childNodes;
    }
    
    public function hasNode(INode $node)
    {
        return $this->store->isLinkedToNode($this->id, $node->getId());
    }
        
    public function getValue()
    {
        try {
        
            return $this->store->getNodeValue($this->id);

        } catch(store\exception\ValueNotFound $e) {
            throw new exception\SomeNodesHasNoValue('Node ' . $this->id . ' can\'t supply a value.');
        }
    }
    
    public function getCommonNodes(INode $node)
    {
        $childIdsHere = $this->store->getLinkedNodes($this->id);
        $childIdsThere = $this->store->getLinkedNodes($node->getId());

        $commonIds = array_intersect($childIdsHere, $childIdsThere);
        
        $commonNodes = [];
        
        foreach ($commonIds as $commonId) {
            $commonNode = $this->factory->makeNode($commonId);
            array_push($commonNodes, $commonNode);
        }
        
        return $commonNodes;
    }
}
