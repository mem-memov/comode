<?php
namespace Comode\syntax;

interface IClause
{
    public function getId();
    public function addCompliment(ICompliment $compliment);
    public function provideFirstCompliment();
    public function provideLastCompliment();
    public function provideNextCompliment(ICompliment $compliment);
    public function providePreviousCompliment(ICompliment $compliment);
    public function provideCompliments();
}