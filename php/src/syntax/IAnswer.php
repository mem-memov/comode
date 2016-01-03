<?php
namespace Comode\syntax;

interface IAnswer
{
    public function getId();
    public function provideWord();
    public function addCompliment(node\ICompliment $complimentNode);
    public function provideCompliments();
}