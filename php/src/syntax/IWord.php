<?php
namespace Comode\syntax;

interface IWord
{
    public function getId();
    public function getValue();
    public function providePredicate();
    public function provideQuestion();
    public function provideAnswer();
}