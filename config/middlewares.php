<?php

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Middleware\Session;

return function (App $app, ContainerInterface $container) {
    $app->addRoutingMiddleware();
    $app->addErrorMiddleware(true, true, true);
    $app->addBodyParsingMiddleware();
    $app->add($container->get(Session::class));
};
