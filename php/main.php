<?php
require __DIR__ . '/vendor/autoload.php';

$config = require('config.php');
$graph = new Comode\graph\Facade($config['graph']);
$syntax = new Comode\syntax\Facade($config);