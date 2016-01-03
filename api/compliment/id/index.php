<?php
require __DIR__ . '/../../../php/main.php';

if (isset($_REQUEST['json'])) {
    $request = json_decode($_REQUEST['json']);
} else {
    $request = $_REQUEST;
}

if (!isset($request['predicate'])) {
    $response = [
        'error' => 'predicate parameter missing'
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
    $predicateWord = $syntax->provideWord($request['predicate']);
    $predicate = $predicateWord->providePredicate();
    
    $questionWord = $syntax->provideWord($request['question']);
    $question = $questionWord->provideQuestion();
    
    $answerWord = $syntax->provideWord($request['answer']);
    $answer = $answerWord->provideAnswer();
    
    $argument = $syntax->provideArgument($predicate, $question);
    
    $compliment = $syntax->provideCompliment($argument, $answer);
    
    $response = [
        'id' => $compliment->getId()
    ];
}

header('Content-Type: text/html; charset=utf-8');
echo json_encode($response);
