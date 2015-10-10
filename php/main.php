<?php
require __DIR__ . '/vendor/autoload.php';

$config = require 'config.php';
$graphFactory = new Comode\graph\Factory($config['graph']);
$syntaxFactory = new Comode\syntax\Factory($graphFactory);
$statement = $syntaxFactory->createStatement();
$fact = $statement->addFact();
$question = $fact->setQuestion('when');
$answer = $fact->setStringAnswer('today');
var_dump($question);