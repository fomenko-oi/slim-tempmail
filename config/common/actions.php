<?php

use App\Http\Action\Main\MainPageAction;
use App\Http\Action\Email\MessagesListAction;
use App\Http\Action\Email\MessagesSendAction;
use App\Http\Action\Main\TestAction;
use Psr\Container\ContainerInterface;
use App\Service\Email\MailService;
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
            $container->get(MailService::class)
        );
    },
    MessagesSendAction::class => function(ContainerInterface $container) {
        return new MessagesSendAction(
            $container->get(MailService::class)
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
];
