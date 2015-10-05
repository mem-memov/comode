<?php
namespace Comode\node\value;

class String implements IValue
{
    private $string;
    
    public function __construct($string)
    {
        $this->string = $string;
    }
    
    public function get()
    {
        return $this->string;
    }
    
    public function hash()
    {
        return md5($this->string);
    }
}
