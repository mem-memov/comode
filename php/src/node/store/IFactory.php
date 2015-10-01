<?php
namespace Comode\node\store;

interface IFactory
{
    /**
     * @return Comode\node\store\IStore
     */
    public function makeStore();
}