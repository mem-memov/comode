<?php
namespace Comode\graph\store\value;

interface IFactory
{
    public function makeString($content);
    
    public function makeFile($path);
    
    public function make(array $structure, array $decorators = []);
}