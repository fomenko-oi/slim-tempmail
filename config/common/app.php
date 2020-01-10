<?php

return [
    \App\Http\Action\Main\MainPageAction::class => function(\Psr\Container\ContainerInterface $container) {
        return new \App\Http\Action\Main\MainPageAction($container->get('view'));
    },
    \App\Http\Action\Email\MessagesListAction::class => function(\Psr\Container\ContainerInterface $container) {
        return new \App\Http\Action\Email\MessagesListAction(
            $container->get(\App\Service\Email\MailService::class)
        );
    },
    \App\Http\Action\Email\MessagesSendAction::class => function(\Psr\Container\ContainerInterface $container) {
        return new \App\Http\Action\Email\MessagesSendAction(
            $container->get(\App\Service\Email\MailService::class)
        );
    },
    \App\Http\Action\Main\TestAction::class => function(\Psr\Container\ContainerInterface $container) {
        return new \App\Http\Action\Main\TestAction(
            $container->get(\Doctrine\ORM\EntityManagerInterface::class)
        );
    }
];
