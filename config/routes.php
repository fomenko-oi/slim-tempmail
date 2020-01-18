<?php

use Slim\App;
use Psr\Container\ContainerInterface;
use App\Http\Action;
use App\Http\Middleware\UserEmailMiddleware;
use App\Http\Middleware\UserLanguageMiddleware;
use App\Http\Action\User\Cabinet\DetectLanguageAction;
use Slim\Routing\RouteCollectorProxy;

return function(App $app, ContainerInterface $container) {
    $app->get('/hello/{name}', Action\Main\MainPageAction::class . ':handle');

    $app->get('/sendmail/{email}', Action\Email\MessagesSendAction::class . ':handle');

    $app->group('/{lang}', function(RouteCollectorProxy $group) {
        $group->get('/user/current_language', DetectLanguageAction::class . ':handle')->setName('user.current_language');
    })
        ->add($container->get(UserEmailMiddleware::class))
        ->add($container->get(UserLanguageMiddleware::class))
    ;

    $app->group('/', function(\Slim\Routing\RouteCollectorProxy $group) {
        $group->put('user/set_email', Action\User\Mailbox\ChangeEmailAction::class . ':handle');
        $group->put('user/random_email', Action\User\Mailbox\SetRandomEmailAction::class . ':handle');
        $group->get('user/current_email', Action\User\Mailbox\DisplayCurrentEmailAction::class . ':handle');
    })->add($container->get(UserEmailMiddleware::class));

    $app->get('/api/domains', Action\Api\Domain\DomainListAction::class . ':handle');
    $app->post('/api/domains', Action\Api\Domain\DomainStoreAction::class . ':handle');

    $app->get('/api/{email}/messages', Action\Api\Message\MessagesListAction::class . ':handle');
    $app->get('/api/message/{id}/source', Action\Api\Message\MessagesSourcesAction::class . ':handle');
    $app->delete('/api/message/{inbox}/{id}', Action\Api\Message\RemoveMessageAction::class . ':handle');
};
