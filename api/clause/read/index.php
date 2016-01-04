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

    $clause = $syntax->fetchClause($request['id']);

    $compliment = $clause->provideFirstCompliment();
    
    $argument = $compliment->provideArgument();
    
    $predicate = $argument->providePredicate();
    $predicateWord = $predicate->provideWord();
    
    $question = $argument->provideQuestion();
    $questionWord = $question->provideWord();
    
    $answer = $compliment->provideAnswer();
    $answerWord = $answer->provideWord();

    $response = [];
    $response[$predicateWord->getValue()] = [];
    $response[$predicateWord->getValue()][$questionWord->getValue()] = $answerWord->getValue();
    
    try {
        while (true) {
            $compliment = $clause->provideNextCompliment($compliment);
            $argument = $compliment->provideArgument();
            
            $question = $argument->provideQuestion();
            $questionWord = $question->provideWord();
            
            $answer = $compliment->provideAnswer();
            $answerWord = $answer->provideWord();
            
            $response[$predicateWord->getValue()][$questionWord->getValue()] = $answerWord->getValue();
        }
    } catch (Comode\syntax\node\sequence\exception\NoNextNode $exception) {
        // looping stopped, do nothing
    }

    header('Content-Type: text/html; charset=utf-8');
    echo json_encode($response);
}
