<?php
namespace Comode\syntax;

interface IAnswerFactory
{
    public function setComplimentFactory(IComplimentFactory $complimentFactory);
    public function provideAnswer(array $structure);
    public function provideAnswersByCompliment(node\ICompliment $complimentNode);
}