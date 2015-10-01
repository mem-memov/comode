<?php
require __DIR__ . '/vendor/autoload.php';

$config = require 'config.php';
$nodeFactory = new Comode\node\Factory($config['node']);
$node = $nodeFactory->makeNode();
$node->addNode();