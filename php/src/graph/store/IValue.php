<?php
namespace Comode\graph\store;

interface Ivalue
{
    public function isFile();
    public function getContent();
}
