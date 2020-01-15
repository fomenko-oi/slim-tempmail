<?php

use App\Http\Action\Main\MainPageAction;
use App\Http\Action\Email\MessagesListAction;
use App\Http\Action\Email\MessagesSendAction;
use App\Http\Action\Main\TestAction;
use Psr\Container\ContainerInterface;
use App\Service\Email\ReceiverService;
use App\Http\Action\Main\DBAction;
use Doctrine\ORM\EntityManagerInterface;
use App\Http\Action\Api\Domain\DomainListAction;
use App\Http\Action\Api\Domain\DomainStoreAction;

return [
    MainPageAction::class => function(ContainerInterface $container) {
        return new MainPageAction($container->get('view'));
    },
    MessagesListAction::class => function(ContainerInterface $container) {
        return new MessagesListAction(
            $container->get(ReceiverService::class)
        );
    },
    MessagesSendAction::class => function(ContainerInterface $container) {
        return new MessagesSendAction(
            $container->get(ReceiverService::class)
        );
    },
    TestAction::class => function(ContainerInterface $container) {
        return new TestAction(
            //$container->get(EntityManagerInterface::class)
        );
    },
    DBAction::class => function(ContainerInterface $container) {
        return new DBAction(
            $container->get(EntityManagerInterface::class)
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
            $container->get(\App\Http\Validator\Validator::class)
        );
    },
    \App\Http\Action\Api\Message\MessagesListAction::class => function(ContainerInterface $container) {
        return new \App\Http\Action\Api\Message\MessagesListAction(
            $container->get(App\Model\Email\UseCase\Index\Handler::class),
            $container->get(\App\Infrastructure\Storage\UrlGenerator::class)
        );
    },
];
