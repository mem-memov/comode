<?php
namespace Comode\syntax;

interface IQuestionFactory
{
    public function setArgumentFactory(IArgumentFactory $argumentFactory);
    public function provideQuestion($string);
    public function provideQuestionsByArgument(node\IArgument $argumentNode);
}