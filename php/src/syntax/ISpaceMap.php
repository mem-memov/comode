<?php
namespace Comode\syntax;

interface ISpaceMap
{
    public function getQuestionNode();
    public function getAnswerNode();
    public function getFactNode();
    public function getStatementNode();
}