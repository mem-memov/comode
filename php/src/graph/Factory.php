<?php
namespace Comode\graph;

class Factory implements IFactory
{
    private $store;

    public function __construct(store\IStore $store)
    {
        $this->store = $store;
    }

    public function makeNode($id = null, $value = '')
    {
        return new Node($this->store, $this, $id, $value);
    }
}
