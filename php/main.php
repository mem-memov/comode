<?php
require __DIR__ . '/vendor/autoload.php';

$routerFactory = new WebApi\router\Factory(array());

$routerFactory->phpArray($path);