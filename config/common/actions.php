<?php

use App\Http\Action\Main\MainPageAction;
use App\Http\Action\Email\MessagesSendAction;
use App\Model\User\Service\Language\LanguageManager;
use Psr\Container\ContainerInterface;
use App\Service\Email\ReceiverService;
use App\Http\Action\Api\Message\MessagesListAction;
use App\Http\Action\Api\Domain\DomainListAction;
use App\Http\Action\Api\Domain\DomainStoreAction;
use App\Infrastructure\Storage\UrlGenerator;
use App\Http\Validator\Validator;
use App\Http\Action\User\Mailbox\SetRandomEmailAction;
use App\Model\Email\Entity\MessageRepository;

return [
    MainPageAction::class => function(ContainerInterface $container) {
        return new MainPageAction(
            $container->get('view'),
            $container->get(MessageRepository::class),
            $container->get(\App\Model\User\Entity\UserProvider::class),
        );
    },
    MessagesSendAction::class => function(ContainerInterface $container) {
        return new MessagesSendAction(
            $container->get(ReceiverService::class)
        );
    },
    DomainListAction::class => function(ContainerInterface $container) {
        return new DomainListAction(
            $container->get(\App\Model\Domain\UseCase\Index\Handler::class)
        );
    },
    DomainStoreAction::class => function(ContainerInterface $container) {
        return new DomainStoreAction(
            $container->get(\App\Model\Domain\UseCase\Create\Handler::class),
            $container->get(Validator::class)
        );
    },
    MessagesListAction::class => function(ContainerInterface $container) {
        return new MessagesListAction(
            $container->get(App\Model\Email\UseCase\Index\Handler::class),
            $container->get(UrlGenerator::class)
        );
    },
    \App\Http\Action\Api\Message\RemoveMessageAction::class => function(ContainerInterface $container) {
        return new \App\Http\Action\Api\Message\RemoveMessageAction(
            $container->get(App\Model\Email\UseCase\Remove\Handler::class),
            $container->get(Validator::class),
            $container->get(MessageRepository::class)
        );
    },
    \App\Http\Action\User\Cabinet\DetectLanguageAction::class => function(ContainerInterface $container) {
        return new \App\Http\Action\User\Cabinet\DetectLanguageAction(
            $container->get(\App\Model\User\Service\Language\LanguageManager::class),
            $container->get('view')
        );
    },
    \App\Http\Action\User\Mailbox\MessagesListAction::class => function(ContainerInterface $container) {
        return new \App\Http\Action\User\Mailbox\MessagesListAction(
            $container->get(\App\Model\User\Entity\UserProvider::class),
            $container->get(MessageRepository::class),
            $container->get('view'),
            $container->get(LanguageManager::class)
        );
    },
    \App\Http\Action\User\Mailbox\MessageDetailsAction::class => function(ContainerInterface $container) {
        return new \App\Http\Action\User\Mailbox\MessageDetailsAction(
            $container->get(\App\Model\User\Entity\UserProvider::class),
            $container->get(MessageRepository::class),
            $container->get('view'),
            $container->get(LanguageManager::class)
        );
    },
    SetRandomEmailAction::class => function(ContainerInterface $container) {
        return new SetRandomEmailAction(
            $container->get(App\Model\Email\UseCase\Random\Handler::class)
        );
    },
];
