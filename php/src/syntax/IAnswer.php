<?php
namespace Comode\syntax;

interface IAnswer
{
    public function getId();
    public function hasArgument(node\IArgument $argumentNode);
    public function addArgument(node\IArgument $argumentNode);
    public function getValue();
    public function isFile();
}