<?php

function __autoload($class)
{
	$class = substr($class, 7);
	require_once 'src/' . $class . '.php';
}

$path = realpath(__DIR__ . '/store');
$fileSystem = new Comode\FileSystem($path);
$node = new Comode\Node($fileSystem);
$node->addNode();

