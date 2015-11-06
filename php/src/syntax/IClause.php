<?php
namespace Comode\syntax;

interface IClause
{
    public function getId();
    public function addCompliment(node\ICompliment $complimentNode);
    public function provideCompliments();
}