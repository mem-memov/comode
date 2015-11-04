<?php
namespace Comode\syntax;

interface IArgument
{
    public function getId();
    public function provideCompliments();
    public function provideQuestion();
    public function providePredicate();
}