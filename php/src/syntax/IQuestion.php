<?php
namespace Comode\syntax;

interface IQuestion
{
    public function provideArgument(operation\IArgumentNodeProvider $argumentNodeProvider);
    public function getValue();
}