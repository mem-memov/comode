<?php
namespace Comode\node\value;

class File implements IValue
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
        return hash_file('md5', $this->value);
    }
}