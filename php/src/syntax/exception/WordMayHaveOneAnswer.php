<?php
namespace Comode\syntax\exception;

final class WordMayHaveOneAnswer extends Exception
{
    public function __construct($wordNode, $answerNodeCount)
    {
        $message = 'Word node ' . $wordNode->getId() . ' has ' . $answerNodeCount . ' answers.';
        parent::__construct($message);
    }
}