<?php
namespace Comode\syntax;

interface IPredicate
{
   public function getId();
   public function getValue();
   public function addArgument(node\IArgument $argumentNode);
   public function fetchClauses();
   public function provideArguments();
   public function provideArgumentByQuestion(IQuestion $question);
}