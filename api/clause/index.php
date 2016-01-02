<?php
require __DIR__ . '/../../php/main.php';

if ($_GET['id']) {
    
    $clauseId = $_GET['id'];
    
    $clause = $syntax->fetchClause($clauseId);

    $firstCompliment = $clause->provideFirstCompliment();
    
    $argument = $firstCompliment->provideArgument();
    
    $predicate = $argument->providePredicate();
    
    $question = $argument->provideQuestion();
    
    $answer = $firstCompliment->provideAnswer();
    
    header('Content-Type: text/html; charset=utf-8');
    
    $response = [];
    $response[$question->getValue()] = $answer->getValue();
    
    echo json_encode($response);
}
