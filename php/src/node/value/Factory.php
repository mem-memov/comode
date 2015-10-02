<?php
namespace Comode\node\value;

class Factory
{
    public function makeFile($path)
    {
        return new File($path);
    }

    public function makeString($string)
    {
        return new String($string);
    }
}