<?php
namespace Comode\node\value;

class String implements IValue
{
    private $value;
    
    public function __construct($value)
    {
        $this->value = $value;
    }
    
    public function get()
    {
        return $this->value;
    }
    
    public function hash()
    {
        return md5($this->value);
    }
}