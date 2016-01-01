<?php
require __DIR__ . '/../../php/main.php';

if ($_GET['id']) {
    
    $clauseId = $_GET['id'];
    
    $clause = $syntax->fetchClause($clauseId);

    $firstCompliment = $clause->provideFirstCompliment();
    
    echo $firstCompliment->getId();
}
