<?php
require __DIR__ . '/../../../php/main.php';

$clause = $syntax->createClause([$compliment]);

if (isset($_REQUEST['json'])) {
    $request = json_decode($_REQUEST['json']);
} else {
    $request = $_REQUEST;
}

if (isset($request)) {
    
}

$response = [
    'clauseId' => $clause->getId()
];


header('Content-Type: text/html; charset=utf-8');
echo json_encode($response);
