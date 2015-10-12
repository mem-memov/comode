<?php
namespace Comode\syntax\operation;

use Comode\graph\INode;

interface IBindAnswerToQuestion
{
    public function setAnswerNode(INode $answerNode);
    public function setQuestionNode(INode $questionNode);
    public function run();
    public function getFactNode();
}