<?php
namespace Comode\syntax\exception;

final class PredicateMustHaveOneWord extends Exception
{
    public function __construct($predicateNode, $wordNodeCount)
    {
        $message = 'Predicate node ' . $predicateNode->getId() . ' has ' . $wordNodeCount . ' words.';
        parent::__construct($message);
    }
}