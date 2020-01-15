<?php

use Slim\App;
use Psr\Container\ContainerInterface;
use App\Http\Action;
use App\Http\Middleware\UserEmailMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function(App $app, ContainerInterface $container) {
    $app->get('/hello/{name}', Action\Main\MainPageAction::class . ':handle');

    $app->get('/sendmail/{email}', Action\Email\MessagesSendAction::class . ':handle');

    $app->group('/', function() use($app) {
        $app->put('/user/set_email', Action\User\ChangeEmailAction::class . ':handle');
        $app->get('/user/current_email', Action\User\DisplayCurrentEmailAction::class . ':handle');
    })->add($container->get(UserEmailMiddleware::class));

    $app->get('/api/domains', Action\Api\Domain\DomainListAction::class . ':handle');
    $app->post('/api/domains', Action\Api\Domain\DomainStoreAction::class . ':handle');

    $app->get('/api/{email}/messages', Action\Api\Message\MessagesListAction::class . ':handle');
    $app->get('/api/{id}/source', Action\Api\Message\MessagesSourcesAction::class . ':handle');
};
