<?php
namespace Comode\syntax;

class Question implements IQuestion
{
    private $string;
    
    public function set($string)
    {
        $this->string = $string;
    }
}