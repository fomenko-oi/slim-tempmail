<?php

use Slim\App;
use Psr\Container\ContainerInterface;
use App\Http\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function(App $app, ContainerInterface $container) {
    $app->get('/hello/{name}', Action\Main\MainPageAction::class . ':handle');

    $app->get('/messages', Action\Email\MessagesListAction::class . ':handle');
    $app->get('/sendmail/{email}', Action\Email\MessagesSendAction::class . ':handle');

    $app->get('/test', function() {
        $doctrine = '';

        die('asdfsafd');
    });
    $app->get('/testdb', Action\Main\TestAction::class);

    $app->get('/hello_new/{name}/{country}', function (Request $request, Response $response, $args) {
        dd($request->getAttribute('name'), $request->getAttribute('country'));

        $response->getBody()->write("Hello, $name");
        return $response;
    });
};
