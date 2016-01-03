<?php
namespace Comode\syntax\exception;

final class QuestionMustHaveOneWord extends Exception
{
    public function __construct($questionNode, $wordNodeCount)
    {
        $message = 'Question node ' . $questionNode->getId() . ' has ' . $wordNodeCount . ' words.';
        parent::__construct($message);
    }
}