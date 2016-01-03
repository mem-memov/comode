<?php
require __DIR__ . '/../../../php/main.php';

if (isset($_REQUEST['json'])) {
    $request = json_decode($_REQUEST['json']);
} else {
    $request = $_REQUEST;
}

if (!isset($request['word'])) {
    $response = [
        'error' => 'word parameter missing'
    ];
} else {
    $answerWord = $syntax->provideWord($request['word']);
    $answer = $answerWord->provideAnswer();
    $response = [
        'id' => $answer->getId()
    ];
}

header('Content-Type: text/html; charset=utf-8');
echo json_encode($response);
