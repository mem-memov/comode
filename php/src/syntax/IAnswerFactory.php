<?php
namespace Comode\syntax;

interface IAnswerFactory
{
    public function createStringAnswer();
    public function createFileAnswer();
}