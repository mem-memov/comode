<?php
namespace Comode\syntax;

interface IAnswerFactory
{
    public function setComplimentFactory(IComplimentFactory $complimentFactory);
    public function provideAnswerByWord(node\IWord $wordNode);
    public function provideAnswersByCompliment(node\ICompliment $complimentNode);
}