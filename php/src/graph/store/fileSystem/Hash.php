<?php
namespace Comode\graph\store\fileSystem;

class Hash implements IHash
{
    public function file($path)
    {
        return hash_file('md5', $path);
    }
    
    public function string($string)
    {
        return md5($string);
    }
}