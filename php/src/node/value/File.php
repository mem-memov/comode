<?php
namespace Comode\node\value;

class File implements IValue
{
    private $path;
    private $hash;
    
    public function __construct($path)
    {
        $this->path = $path;
    }
    
    public function get()
    {
        return $this->path;
    }
    
    public function hash()
    {
        if (is_null($this->hash)) {
            $this->hash = hash_file('md5', $this->path);
        }
        
        return $this->hash;
    }
}
