<?php
require __DIR__ . '/../../php/main.php';

$predicate = $syntax->providePredicate('работает');

$question = $syntax->provideQuestion('что');

$answer = $syntax->provideAnswer('система');

$argument = $syntax->provideArgument($predicate, $question);

$compliment = $syntax->provideCompliment($argument, $answer);

$clause = $syntax->createClause([$compliment]);

echo $clause->getId();