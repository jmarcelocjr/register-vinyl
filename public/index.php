<?php
require_once __DIR__.'/../vendor/autoload.php';

$container = require __DIR__.'/../src/container.php';

$app = $container['app'];

$app->get('/', function ($request, Interop\Http\ServerMiddleware\DelegateInterface $delegate) {
    return new Zend\Diactoros\Response\TextResponse("It Works!");
});

$app->pipeRoutingMiddleware();
$app->pipeDispatchMiddleware();

$app->run();