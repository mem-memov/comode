<?php
namespace Comode\syntax;

interface IQuestionFactory
{
    public function setArgumentFactory(IArgumentFactory $argumentFactory);
    public function provideQuestionByWord(node\IWord $wordNode);
    public function provideQuestionsByArgument(node\IArgument $argumentNode);
}