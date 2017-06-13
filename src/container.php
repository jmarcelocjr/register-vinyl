<?php
use Xtreamwayz\Pimple\Container as PimpleContainer;
use Zend\Expressive\Container;

$container = new PimpleContainer;

$container['config'] = function () {
    return require __DIR__ . '/../config/config.php';
};

$container['db'] = function ($c) {
    $db = $c['config']['db'];
    return new PDO(
            'mysql:host='.$db['host'].';dbname='.$db['database'],
            $db['user'],
            $db['password']
    );
};

$container['twig'] = function ($c) {
    $templatesPath = $c['config']['view']['template_path'];

    $loader = new Twig_Loader_Filesystem($templatesPath);
    $twig = new Twig_Environment($loader);

    return new \Zend\Expressive\Twig\TwigRenderer($twig);
};

$container['aura'] = function () {
    return new \Aura\Router\RouterContainer();
};

$container['Zend\Expressive\Router\RouterInterface'] = function ($c) {
    return new \Zend\Expressive\Router\AuraRouter($c['aura']);
};

$container['app'] = new Container\ApplicationFactory($c);

$container[RegisterVinyl\Middleware\Vinyl\Table::class] = function ($c) {
    return new RegisterVinyl\Middleware\Vinyl\Table($c['db'], $c['twig']);
};

$container[RegisterVinyl\Middleware\Vinyl\Form::class] = function ($c) {
    return new RegisterVinyl\Middleware\Vinyl\Form($c['db'], $c['twig']);
};

$container[RegisterVinyl\Middleware\Vinyl\Save::class] = function ($c) {
    return new RegisterVinyl\Middleware\Vinyl\Save($c['db']);
};

$container[RegisterVinyl\Middleware\Vinyl\Delete::class] = function ($c) {
    return new RegisterVinyl\Middleware\Vinyl\Delete($c['db']);
};

return $container;