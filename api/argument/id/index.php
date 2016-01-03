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
} else {
    $predicateWord = $syntax->provideWord($request['predicate']);
    $predicate = $predicateWord->providePredicate();
    
    $questionWord = $syntax->provideWord($request['question']);
    $question = $questionWord->provideQuestion();
    
    $argument = $syntax->provideArgument($predicate, $question);
    
    $response = [
        'id' => $argument->getId()
    ];
}

header('Content-Type: text/html; charset=utf-8');
echo json_encode($response);
