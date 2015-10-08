<?php
namespace Comode\graph;

use Comode\graph\store\IStore;
use Comode\graph\store\ValueNotFound;
use Comode\graph\value\IValue;

class Node implements INode
{
    private $store;
    private $valueFactory;
    private $nodeFactory;
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
    public function __construct(IStore $store, IValueFactory $valueFactory, INodeFactory $nodeFactory, $id = null, $isFile = null, $content = null)
    {
        $this->store = $store;
        $this->valueFactory = $valueFactory;
        $this->nodeFactory = $nodeFactory;
        
        if (is_null($id)) {
            if (is_bool($isFile) && !is_null($content)) {
                $id = $this->store->createNode(new store\Value($isFile, $content));
            } else {
                $id = $this->store->createNode();
            }
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
        
    public function getNodes()
    {
        $childIds = $this->store->getChildNodes($this->id);
        
        $childNodes = [];
        
        foreach ($childIds as $childId) {
            $childNode = $this->nodeFactory->readNode($childId);
            array_push($childNodes, $childNode);
        }

        return $childNodes;
    }
        
    public function getValue()
    {
        $storeValue = $this->store->getValueByNodeId($this->id);

        if ($storeValue->isFile()) {
            return $this->valueFactory->makeFileValue($storeValue->getContent());
        } else {
            return $this->valueFactory->makeStringValue($storeValue->getContent());
        }
    }
}
