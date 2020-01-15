<?php

use Psr\Container\ContainerInterface;
use App\Infrastructure\Model\Domain\Entity\DoctrineDomainRepository;
use App\Infrastructure\Model\Message\Entity\DoctrineMessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Infrastructure\Model\Service\DoctrineFlusher;
use App\Model\Domain\Entity\DomainRepository;
use App\Model\Email\Entity\MessageRepository;
use App\Model\Flusher;
use App\Model\EventDispatcher;

return [
    Flusher::class => function (ContainerInterface $container) {
        return new DoctrineFlusher(
            $container->get(EntityManagerInterface::class),
            $container->get(EventDispatcher::class)
        );
    },
    MessageRepository::class => function(ContainerInterface $container) {
        return new DoctrineMessageRepository(
            $container->get(EntityManagerInterface::class)
        );
    },
    \App\Model\Domain\UseCase\Index\Handler::class => function(ContainerInterface $container) {
        return new \App\Model\Domain\UseCase\Index\Handler(
            $container->get(\App\Model\Domain\Entity\DomainRepository::class)
        );
    },
    \App\Model\Email\UseCase\Source\Handler::class => function(ContainerInterface $container) {
        return new \App\Model\Email\UseCase\Source\Handler(
            $container->get(\Ddeboer\Imap\Server::class),
            $container->get(MessageRepository::class)
        );
    },
    DomainRepository::class => function(ContainerInterface $container) {
        return new DoctrineDomainRepository($container->get(EntityManagerInterface::class));
    },
];
