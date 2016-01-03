<?php
require __DIR__ . '/../../php/main.php';

$predicateWord = $syntax->provideWord('работать');
$predicate = $predicateWord->providePredicate();

$questionWord = $syntax->provideWord('что');
$question = $questionWord->provideQuestion();

$answerWord = $syntax->provideWord('система');
$answer = $answerWord->provideAnswer();

$argument = $syntax->provideArgument($predicate, $question);

$compliment = $syntax->provideCompliment($argument, $answer);

$clause = $syntax->createClause([$compliment]);

echo $clause->getId();