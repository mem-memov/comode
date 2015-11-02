<?php
namespace Comode\syntax;

interface IArgument
{
    public function getId();
    public function addClause(node\IClause $clauseNode);
    public function provideStringCompliment($string);
    public function provideFileCompliment($path);
    public function getQuestion();
}