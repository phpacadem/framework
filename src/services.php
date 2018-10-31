<?php


use Psr\Http\Message\ServerRequestInterface;
use Zend\HttpHandlerRunner\Emitter\EmitterInterface;

$sources = [

];

$services = [

    \PhpAcadem\framework\ApplicationInterface::class => DI\factory(function (
        \PhpAcadem\framework\Application $application
    ) {
        return $application;
    }),

    // default definition of Application. Possible to redefine in your app
    \PhpAcadem\framework\Application::class => DI\factory(function (
        ServerRequestInterface $request,
        \PhpAcadem\framework\view\ViewEngineInterface $view,
        \PhpAcadem\framework\route\Router $router,
        \PhpAcadem\framework\middleware\ErrorHandlerMiddlewareInterface $errorHandlerMiddleware
    ) {
        $app = new PhpAcadem\framework\Application($request, $view, $router);

        $app->middleware($errorHandlerMiddleware); //default handler(PhpAcadem\framework\middleware\ErrorHandlerMiddleware) will process errors if not specified

        return $app;
    }),

    \PhpAcadem\framework\route\Router::class => DI\factory(function (
        \League\Route\Strategy\StrategyInterface $strategy
    ) {
        $router = new \PhpAcadem\framework\route\Router();
        $router->setStrategy($strategy);
        return $router;
    }),


    \PhpAcadem\framework\console\ApplicationInterface::class => DI\factory(function (
        \PhpAcadem\framework\console\Application $application
    ) {
        return $application;
    }),

    // default definition of Application. Possible to redefine in your app
    \PhpAcadem\framework\console\Application::class => DI\factory(function (
        \Psr\Container\ContainerInterface $c
    ) {
        $cli = new \PhpAcadem\framework\console\Application('Console App');

        $commands = $c->get('commands');
        $cli->addCommands($commands);


        return $cli;
    }),


    \League\Route\Strategy\StrategyInterface::class => DI\factory(function (\Psr\Container\ContainerInterface $c) {
        $strategy = new \PhpAcadem\framework\route\strategy\ApplicationStrategy();
        $strategy->setContainer($c);
        return $strategy;
    }),

    \PhpAcadem\framework\middleware\ErrorHandlerMiddlewareInterface::class => DI\factory(function (\Psr\Container\ContainerInterface $c) {

        $errorHandler = $c->has('errorHandler') ? $c->get('errorHandler') : '';
        $debug = $c->has('debug') ? $c->has('debug') : false;
        return new \PhpAcadem\framework\middleware\ErrorHandlerMiddleware($errorHandler, $debug);
    }),

    \PhpAcadem\framework\view\ViewEngineInterface::class => DI\factory(function (\Psr\Container\ContainerInterface $c, \PhpAcadem\framework\route\UrlInterface $url) {
        $view = new \PhpAcadem\framework\view\ViewEngine($c->get('templatePath'), 'phtml');
        $view->setUrl($url);
        return $view;
    }),

    \PhpAcadem\framework\route\UrlInterface::class => DI\factory(function (\PhpAcadem\framework\route\Router $router, \FastRoute\RouteParser\Std $parser) {
        $url = new \PhpAcadem\framework\route\Url($router, $parser);
        return $url;
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
