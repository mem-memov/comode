<?php
namespace Comode\syntax\exception;

final class WordMayHaveOnePredicate extends Exception
{
    public function __construct($wordNode, $predicateNodeCount)
    {
        $message = 'Word node ' . $wordNode->getId() . ' has ' . $predicateNodeCount . ' predicates.';
        parent::__construct($message);
    }
}