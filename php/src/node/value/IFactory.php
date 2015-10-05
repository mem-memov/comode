<?php
namespace Comode\node\value;

interface IFactory
{
    public function makeFile($path);
    public function makeString($string);
}
