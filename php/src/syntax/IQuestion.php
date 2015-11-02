<?php
namespace Comode\syntax;

interface IQuestion
{
    public function provideArgument(operation\IArgumentNodeProvider $argumentNodeProvider);
}