<?php
namespace Comode\syntax;

interface IPredicate
{
   public function getId();
   public function provideWord();
   public function addArgument(node\IArgument $argumentNode);
   public function provideArguments();
   public function provideArgumentByQuestion(IQuestion $question);
}