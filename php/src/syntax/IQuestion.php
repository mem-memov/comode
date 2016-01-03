<?php
namespace Comode\syntax;

interface IQuestion
{
    public function getId();
    public function provideWord();
    public function addArgument(node\IArgument $argumentNode);
    public function provideArguments();
}