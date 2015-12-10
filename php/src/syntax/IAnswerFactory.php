<?php
namespace Comode\syntax;

interface IAnswerFactory
{
    public function setComplimentFactory(IComplimentFactory $complimentFactory);
    public function provideAnswer($value);
    public function provideAnswersByCompliment(node\ICompliment $complimentNode);
}