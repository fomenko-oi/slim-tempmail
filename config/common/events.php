<?php

use App\Model\EventDispatcher;
use Psr\Container\ContainerInterface;
use App\Infrastructure\Model\EventDispatcher\SyncEventDispatcher;
use App\Model\Domain\Entity\Event;
use App\Infrastructure\Model\EventDispatcher\Listener;
use App\Model\Email\Entity\Event\MessageCreated;
use App\Model\Email\Entity\Event\MessageUploaded;

return [
    EventDispatcher::class => function (ContainerInterface $container) {
        return new SyncEventDispatcher(
            $container,
            [
                Event\DomainCreated::class => [
                    Listener\Domain\CreatedListener::class,
                ],
                MessageCreated::class => [

                ],
                MessageUploaded::class => [
                    Listener\Message\SocketNotificationListener::class,
                ],
            ]
        );
    },
    Listener\Domain\CreatedListener::class => function (ContainerInterface $container) {
        return new Listener\Domain\CreatedListener(
            $container->get(Swift_Mailer::class),
            $container->get('config')['mailer']['from'],
            $container->get('config')['mailer']['notification_email']
        );
    },
];
