<?php

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Middleware\Session;

return function (App $app, ContainerInterface $container) {
    $app->addRoutingMiddleware();
    $app->addBodyParsingMiddleware();
    $app->add($container->get(Session::class));
    $app->addErrorMiddleware(true, true, true);
};
