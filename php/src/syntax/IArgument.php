<?php
namespace Comode\syntax;

interface IArgument
{
    public function getId();
    public function addCompliment(node\ICompliment $complimentNode);
    public function provideCompliments();
    public function provideQuestion();
    public function providePredicate();
    public function provideComplimentByAnswer(IAnswer $answer);
}