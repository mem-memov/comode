<?php
namespace Comode\node\store;

interface IValue
{
    public function isFile();
    public function getContent();
}