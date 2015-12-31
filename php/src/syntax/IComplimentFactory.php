<?php
namespace Comode\syntax;

interface IComplimentFactory
{
    public function setClauseFactory(IClauseFactory $clauseFactory);
    public function provideCompliment(IArgument $argument, IAnswer $answer);
    public function provideComplimentsByClause(node\IClause $clauseNode);
    public function provideFirstComplimentInClause(node\sequence\ICompliment $complimentSequence);
    public function provideLastComplimentInClause(node\sequence\ICompliment $complimentSequence);
    public function provideNextComplimentInClause(node\sequence\ICompliment $complimentSequence, node\ICompliment $complimentNode);
    public function providePreviousComplimentInClause(node\sequence\ICompliment $complimentSequence, node\ICompliment $complimentNode);
    public function provideComplimentsByArgument(node\IArgument $argumentNode);
    public function provideComplimentsByAnswer(node\IAnswer $answerNode);
}