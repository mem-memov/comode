<?php
namespace Comode\syntax;

interface IQuestion
{
    public function getId();
    public function provideArgument(operation\IArgumentNodeProvider $argumentNodeProvider);
    public function getValue();
}