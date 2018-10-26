<?php


use Psr\Http\Message\ServerRequestInterface;
use Zend\HttpHandlerRunner\Emitter\EmitterInterface;

$sources = [

];

$services = [

    // default definition of Application. Necessary to define in your app
    \PhpAcadem\framework\Application::class => DI\factory(function (
        \PhpAcadem\framework\view\ViewEngineInterface $view,
        \League\Route\Strategy\StrategyInterface $strategy,
        \PhpAcadem\framework\middleware\ErrorHandlerMiddlewareInterface $errorHandlerMiddleware
    ) {
        $app = new PhpAcadem\framework\Application();

        $app->setStrategy($strategy);
        $app->setView($view);

        $app->middleware($errorHandlerMiddleware); //default handler(PhpAcadem\framework\middleware\ErrorHandlerMiddleware) will process errors if not specified

        return $app;

    })->parameter('debug', DI\get('debug')),


    \League\Route\Strategy\StrategyInterface::class => DI\factory(function (\Psr\Container\ContainerInterface $c) {
        $strategy = new \PhpAcadem\framework\route\strategy\ApplicationStrategy();
        $strategy->setContainer($c);
        return $strategy;
    }),

    \PhpAcadem\framework\view\ViewEngineInterface::class => DI\factory(function (\Psr\Container\ContainerInterface $c) {
        $view = new \PhpAcadem\framework\view\ViewEngine($c->get('templatePath'), 'phtml');
        return $view;
    }),


    ServerRequestInterface::class => DI\factory(function () {
        return \Zend\Diactoros\ServerRequestFactory::fromGlobals();
    }),

    EmitterInterface::class => DI\factory(function () {
        return new \Zend\HttpHandlerRunner\Emitter\SapiEmitter();
    }),

];

foreach ($sources as $source) {
    $services = array_replace($services, require($source));
}
return $services;
