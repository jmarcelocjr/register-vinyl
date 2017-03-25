<?php use Xtreamwayz\Pimple\Container as PimpleContainer; use Zend\Expressive\Container;

$container = new PimpleContainer;

$container['config'] = function () {
    return require __DIR__ . '/../config/config.php';
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

$container['Zend\Expressive\Whoops'] = new Container\WhoopsFactory();
$container['Zend\Expressive\WhoopsPageHandler'] = new Container\WhoopsPageHandlerFactory();
$container['Zend\Expressive\Middleware\ErrorHandler'] = new Container\ErrorHandlerFactory();
$container['Zend\Expressive\Middleware\ErrorResponseGenerator'] = new Container\WhoopsErrorResponseGeneratorFactory();

return $container;