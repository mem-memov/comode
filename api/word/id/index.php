<?php
require __DIR__ . '/../../../php/main.php';

if (isset($_REQUEST['json'])) {
    $request = json_decode($_REQUEST['json']);
} else {
    $request = $_REQUEST;
}

if (!isset($request['value'])) {
    $response = [
        'error' => 'value parameter missing'
    ];
} else {
    $word = $syntax->provideWord($request['value']);
    $response = [
        'id' => $word->getId(),
    ];
}

header('Content-Type: text/html; charset=utf-8');
echo json_encode($response);
