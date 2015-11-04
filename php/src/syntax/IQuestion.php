<?php
namespace Comode\syntax;

interface IQuestion
{
    public function getId();
    public function addArgument(node\IArgument $argumentNode);
    public function getValue();
    public function provideArguments();
}