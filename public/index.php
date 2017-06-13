<?php
require_once __DIR__.'/../vendor/autoload.php';

$container = require __DIR__.'/../src/container.php';

define('BASE_URL', $container['config']['base']['url']);
define('BASE_PATH', $container['config']['base']['path']);

$app = $container['app'];

$app->get('/', function($request, $delegate){
    return new Zend\Diactoros\Response\EmptyResponse(302, [
        'Location' => '/list-vinyl'
    ]);
});

$app->get('/list-vinyl{/page}', \RegisterVinyl\Middleware\Vinyl\Table::class);

$app->get('/vinyl{/id}', \RegisterVinyl\Middleware\Vinyl\Form::class);

$app->post('/vinyl', [
    \RegisterVinyl\Middleware\Vinyl\Save::class,
    \RegisterVinyl\Middleware\Vinyl\Table::class
]);

$app->get('/vinyl/delete/{id}', [
	\RegisterVinyl\Middleware\Vinyl\Delete::class,
	function($request, $delegate){
	    return new Zend\Diactoros\Response\EmptyResponse(302, [
	        'Location' => '/list-vinyl'
	    ]);
	}
]);

$app->pipeRoutingMiddleware();
$app->pipeDispatchMiddleware();

$app->run();