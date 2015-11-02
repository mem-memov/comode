<?php
namespace Comode\syntax;

interface ICompliment
{
    public function hasArgument(INode $argumentNode);
    public function addArgument(INode $argumentNode);
    public function getValue();
    public function isFile();
}