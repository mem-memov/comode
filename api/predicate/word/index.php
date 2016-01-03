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
} else {
    try {
        $predicate = $syntax->fetchPredicate($request['id']);
        $word = $predicate->provideWord();
        $response = [
            'word' => $word->getValue(),
        ];
    } catch (Comode\syntax\node\exception\NodeOfWrongType $exception) {
        $response = [
            'error' => $exception->getMessage()
        ];
    }

}

header('Content-Type: text/html; charset=utf-8');
echo json_encode($response);
