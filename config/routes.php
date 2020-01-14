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

    $app->get('/api/domain', Action\Api\Domain\DomainListAction::class . ':handle');
    $app->post('/api/domain', Action\Api\Domain\DomainStoreAction::class . ':handle');

    $app->get('/api/{email}/message', Action\Api\Message\MessagesListAction::class . ':handle');

    $app->get('/testdb', Action\Main\DBAction::class . ':handle');
};
