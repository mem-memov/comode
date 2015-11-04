<?php
namespace Comode\syntax;

interface IComplimentFactory
{
    public function setClauseFactory(IClauseFactory $clauseFactory);
    public function provideCompliment(IArgument $argument, IAnswer $answer);
    public function provideComplimentsByClause(node\IClause $clauseNode);
    public function provideComplimentsByArgument(node\IArgument $argumentNode);
    public function provideComplimentsByAnswer(node\IAnswer $answerNode);
}