<?php
namespace Comode\node\store;

interface Ivalue
{
    public function isFile();
    public function getContent();
}
