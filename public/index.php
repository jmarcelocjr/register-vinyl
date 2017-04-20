<?php
require_once __DIR__.'/../vendor/autoload.php';

$container = require __DIR__.'/../src/container.php';

define('BASE_URL', $container['config']['base']['url']);
define('BASE_PATH', $container['config']['base']['path']);

$app = $container['app'];

$app->get('/list-vinyl{/page}', \RegisterVinyl\Middleware\Vinyl\Table::class);

$app->get('/vinyl', \RegisterVinyl\Middleware\Vinyl\Form::class);
$app->post('/vinyl', [
    \RegisterVinyl\Middleware\Vinyl\Add::class,
    \RegisterVinyl\Middleware\Vinyl\Table::class
]);

$app->pipeRoutingMiddleware();
$app->pipeDispatchMiddleware();

$app->run();