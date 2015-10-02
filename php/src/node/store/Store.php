<?php
namespace Comode\node\store;

class Store implements IStore
{
    private $store;
    
    public function __construct(IStore $store)
    {
        $this->store = $store;
    }
    
    public function idExists($id)
    {
        return $this->store->idExists($id);
    }

    public function createId()
    {
        return $this->store->createId();
    }

    public function linkIds($fromId, $toId)
    {
        return $this->store->linkIds($fromId, $toId);
    }
    
    public function getChildIds($id)
    {
        return $this->store->getChildIds($id);
    }
    
    public function getIdsByValue(IValue $value)
    {
        return $this->store->getIdsByValue($value);
    }
}