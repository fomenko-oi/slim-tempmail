<?php

use App\Http\Action\Api\Domain\DomainListAction;
use App\Http\Action\Api\Domain\DomainStoreAction;
use App\Http\Action\Api\Message\MessagesListAction as ApiMessagesListAction;
use App\Http\Action\Api\Message\MessagesSourcesAction;
use App\Http\Action\Api\Message\RemoveMessageAction;
use App\Http\Action\Email\MessagesSendAction;
use App\Http\Action\Main\MainPageAction;
use App\Http\Action\User\Cabinet\ChangeEmailAction as ChangeCabinetEmailAction;
use App\Http\Action\User\Mailbox\ChangeEmailAction;
use App\Http\Action\User\Mailbox\DisplayCurrentEmailAction;
use App\Http\Action\User\Mailbox\MessageAttachmentAction;
use App\Http\Action\User\Mailbox\MessageDeleteAction;
use App\Http\Action\User\Mailbox\MessageDetailsAction;
use App\Http\Action\User\Mailbox\MessagesListAction;
use App\Http\Action\User\Mailbox\MessageSourceAction;
use App\Http\Action\User\Mailbox\SetRandomEmailAction;
use App\Model\Email\Entity\MessageRepository;
use Laminas\Diactoros\Response\HtmlResponse;
use Slim\App;
use Psr\Container\ContainerInterface;
use App\Http\Action;
use App\Http\Middleware\UserEmailMiddleware;
use App\Http\Middleware\UserLanguageMiddleware;
use App\Http\Action\User\Cabinet\DetectLanguageAction;
use Slim\Routing\RouteCollectorProxy;

return function(App $app, ContainerInterface $container) {
    $app->get('/', MainPageAction::class . ':handle')->setName('index')
        ->add($container->get(UserEmailMiddleware::class));

    $app->get('/frontend', function() use($container) {
        $view = $container->get('view');

        return new HtmlResponse(
            $view->render('layouts/frontend_v2.html.twig', [
                'messages' => $container->get(MessageRepository::class)->findByAddress('admin.test', 'admin')
            ]),
        );
    });

    $app->group('', function(RouteCollectorProxy $group) {
        $group->get('/{lang}[/]', MainPageAction::class . ':handle')->setName('index');

        $group->post('/{lang}/user/messages', MessagesListAction::class . ':handle');
        $group->get('/{lang}/message/{message}', MessageDetailsAction::class . ':handle');
        $group->delete('/{lang}/message/{message}', MessageDeleteAction::class . ':handle');
        $group->get('/{lang}/message/{message}/source', MessageSourceAction::class . ':handle');
        $group->get('/{lang}/message/{message}/attachment/{file}', MessageAttachmentAction::class . ':handle');
        $group->put('/{lang}/user/set_email', ChangeEmailAction::class . ':handle');
        $group->put('/{lang}/user/random_email', SetRandomEmailAction::class . ':handle');
        $group->get('/{lang}/user/current_email', DisplayCurrentEmailAction::class . ':handle');
        $group->get('/{lang}/user/settings', ChangeCabinetEmailAction::class . ':handle');
    })
        ->add($container->get(UserEmailMiddleware::class))
        ->add($container->get(UserLanguageMiddleware::class))
    ;

    $app->get('/sendmail/{email}', MessagesSendAction::class . ':handle');

    $app->group('/{lang}', function(RouteCollectorProxy $group) {
        $group->get('/user/current_language', DetectLanguageAction::class . ':handle')->setName('user.current_language');
    })
        ->add($container->get(UserEmailMiddleware::class))
        ->add($container->get(UserLanguageMiddleware::class))
    ;

    $app->get('/api/domains', DomainListAction::class . ':handle');
    $app->post('/api/domains', DomainStoreAction::class . ':handle');

    $app->get('/api/{email}/messages', ApiMessagesListAction::class . ':handle');
    $app->get('/api/message/{id}/source', MessagesSourcesAction::class . ':handle');
    $app->delete('/api/message/{inbox}/{id}', RemoveMessageAction::class . ':handle');
};
