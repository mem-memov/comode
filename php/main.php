<?php
require __DIR__ . '/vendor/autoload.php';

$config = require 'config.php';
$path = realpath(__DIR__ . '/store');
$fileSystem = new Comode\FileSystem($path);
$node = new Comode\Node($fileSystem);
$node->addNode();