<?php
namespace Comode\syntax;

interface IClause
{
    public function getId();
    public function setPredicate($predicateString);
    public function getPredicate();
    public function addStringCompliment($questionString, $answerString);
    public function addFileCompliment($questionString, $answerPath);
    public function getCompliments();
}