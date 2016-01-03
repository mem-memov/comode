<?php
namespace Comode\syntax\exception;

final class WordMayHaveOneQuestion extends Exception
{
    public function __construct($wordNode, $questionNodeCount)
    {
        $message = 'Word node ' . $wordNode->getId() . ' has ' . $questionNodeCount . ' questions.';
        parent::__construct($message);
    }
}