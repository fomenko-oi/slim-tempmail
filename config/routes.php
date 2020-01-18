<?php

use Slim\App;
use Psr\Container\ContainerInterface;
use App\Http\Action;
use App\Http\Middleware\UserEmailMiddleware;
use App\Http\Middleware\UserLanguageMiddleware;
use App\Http\Action\User\Cabinet\DetectLanguageAction;
use Slim\Routing\RouteCollectorProxy;

return function(App $app, ContainerInterface $container) {
    $app->group('', function(RouteCollectorProxy $group) {
        $group->get('/{lang}/', Action\Main\MainPageAction::class . ':handle')->setName('index');

        $group->post('/{lang}/user/messages', Action\User\Mailbox\MessagesListAction::class . ':handle');
        $group->get('/{lang}/message/{message}', Action\User\Mailbox\MessageDetailsAction::class . ':handle');
        $group->put('/{lang}/user/set_email', Action\User\Mailbox\ChangeEmailAction::class . ':handle');
        $group->put('/{lang}/user/random_email', Action\User\Mailbox\SetRandomEmailAction::class . ':handle');
        $group->get('/{lang}/user/current_email', Action\User\Mailbox\DisplayCurrentEmailAction::class . ':handle');
    })
        ->add($container->get(UserEmailMiddleware::class))
        ->add($container->get(UserLanguageMiddleware::class))
    ;

    $app->get('/sendmail/{email}', Action\Email\MessagesSendAction::class . ':handle');

    $app->group('/{lang}', function(RouteCollectorProxy $group) {
        $group->get('/user/current_language', DetectLanguageAction::class . ':handle')->setName('user.current_language');
    })
        ->add($container->get(UserEmailMiddleware::class))
        ->add($container->get(UserLanguageMiddleware::class))
    ;

    $app->get('/api/domains', Action\Api\Domain\DomainListAction::class . ':handle');
    $app->post('/api/domains', Action\Api\Domain\DomainStoreAction::class . ':handle');

    $app->get('/api/{email}/messages', Action\Api\Message\MessagesListAction::class . ':handle');
    $app->get('/api/message/{id}/source', Action\Api\Message\MessagesSourcesAction::class . ':handle');
    $app->delete('/api/message/{inbox}/{id}', Action\Api\Message\RemoveMessageAction::class . ':handle');
};
