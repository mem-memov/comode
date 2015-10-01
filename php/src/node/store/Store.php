<?php
namespace Comode\node\store;

class Store implements IStore
{
    private $store;
    
    public function __construct(IStore $store)
    {
        $this->store = $store;
    }
    
    public function itemExists($id)
    {
        return $this->store->itemExists($id);
    }

    public function createItem()
    {
        return $this->store->createItem();
    }

    public function linkItems($fromId, $toId)
    {
        return $this->store->linkItems($fromId, $toId);
    }
}