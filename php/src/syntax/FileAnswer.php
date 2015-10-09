<?php
namespace Comode\syntax;

class FileAnswer implements IAnswer
{
    private $path;
    
    public function set($value)
    {
        $this->path = $value;
    }
}