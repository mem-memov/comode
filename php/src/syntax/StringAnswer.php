<?php
namespace Comode\syntax;

class StringAnswer implements IAnswer
{
    private $string;
    
    public function set($string)
    {
        $this->string = $string;
    }
}