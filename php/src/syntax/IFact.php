<?php
namespace Comode\syntax;

interface IFact
{
    public function setQuestion($string);
    public function setStringAnswer($string);
    public function setFileAnswer($path);
}