<?php
require __DIR__ . '/vendor/autoload.php';

$config = require 'config.php';
$nodeFactory = new Comode\node\Factory($config['node']);
$node1 = $nodeFactory->makeNode(null, 'когда?');
$node2 = $nodeFactory->makeNode();
$node1->addNode($node2);