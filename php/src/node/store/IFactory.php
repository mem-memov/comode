<?php
namespace Comode\node\store;

interface Factory
{
    /**
     * @return Comode\node\store\IStore
     */
    public function makeStore();
}