<?php
namespace Comode\syntax\exception;

final class AnswerMustHaveOneWord extends Exception
{
    public function __construct($answerNode, $wordNodeCount)
    {
        $message = 'Answer node ' . $answerNode->getId() . ' has ' . $wordNodeCount . ' words.';
        parent::__construct($message);
    }
}