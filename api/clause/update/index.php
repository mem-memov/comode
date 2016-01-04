<?php
require __DIR__ . '/../../../php/main.php';

if (isset($_REQUEST['json'])) {
    $request = json_decode($_REQUEST['json']);
} else {
    $request = $_REQUEST;
}

if (!isset($request['id'])) {
    $response = [
        'error' => 'id parameter missing'
    ];
}elseif (!isset($request['question'])) {
    $response = [
        'error' => 'question parameter missing'
    ];
}elseif (!isset($request['answer'])) {
    $response = [
        'error' => 'answer parameter missing'
    ];
} else {
    $clause = $syntax->fetchClause($request['id']);
    
    $questionWord = $syntax->provideWord($request['question']);
    $question = $questionWord->provideQuestion();
    
    $answerWord = $syntax->provideWord($request['answer']);
    $answer = $answerWord->provideAnswer();
    
    $firstCompliment = $clause->provideFirstCompliment();
    $firstArgument = $firstCompliment->provideArgument();
    $predicate = $firstArgument->providePredicate();
    
    $argument = $syntax->provideArgument($predicate, $question);
    
    $compliment = $syntax->provideCompliment($argument, $answer);

    $clause->addCompliment($compliment);
    
    $response = [
        'id' => $clause->getId()
    ];
}


header('Content-Type: text/html; charset=utf-8');
echo json_encode($response);
