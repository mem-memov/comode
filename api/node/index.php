<?php
require __DIR__ . '/../../php/main.php';

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
    $node = $graph->makeNode($request['id']);
    
    $response = [
        'id' => $node->getId(),
        'value' => $node->getValue(),
        'nodes' => []
    ];
    
    $nodes = $node->getNodes();
    
    foreach ($nodes as $linkedNode) {
        array_push($response['nodes'], [
            'id' => $linkedNode->getId(),
            'value' => $linkedNode->getValue()
        ]);
    }

}

header('Content-Type: text/html; charset=utf-8');
echo json_encode($response);
