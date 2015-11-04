<?php
namespace Comode\syntax;

interface IAnswerFactory
{
    public function setComplimentFactory(IComplimentFactory $complimentFactory);
    public function provideStringAnswer($string);
    public function provideFileAnswer($path);
}