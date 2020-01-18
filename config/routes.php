<?php

use Slim\App;
use Psr\Container\ContainerInterface;
use App\Http\Action;
use App\Http\Middleware\UserEmailMiddleware;

return function(App $app, ContainerInterface $container) {
    $app->get('/hello/{name}', Action\Main\MainPageAction::class . ':handle');

    $app->get('/sendmail/{email}', Action\Email\MessagesSendAction::class . ':handle');

    $app->group('/', function() use($app) {
        $app->put('/user/set_email', Action\User\Mailbox\ChangeEmailAction::class . ':handle');
        $app->put('/user/random_email', Action\User\Mailbox\SetRandomEmailAction::class . ':handle');
        $app->get('/user/current_email', Action\User\Mailbox\DisplayCurrentEmailAction::class . ':handle');
    })->add($container->get(UserEmailMiddleware::class));

    $app->get('/api/domains', Action\Api\Domain\DomainListAction::class . ':handle');
    $app->post('/api/domains', Action\Api\Domain\DomainStoreAction::class . ':handle');

    $app->get('/api/{email}/messages', Action\Api\Message\MessagesListAction::class . ':handle');
    $app->get('/api/message/{id}/source', Action\Api\Message\MessagesSourcesAction::class . ':handle');
    $app->delete('/api/message/{inbox}/{id}', Action\Api\Message\RemoveMessageAction::class . ':handle');
};
