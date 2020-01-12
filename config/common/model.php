<?php

use Psr\Container\ContainerInterface;
use App\Infrastructure\Model\Domain\Entity\DoctrineDomainRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Infrastructure\Model\Service\DoctrineFlusher;
use App\Model\Flusher;
use App\Model\EventDispatcher;

return [
    Flusher::class => function (ContainerInterface $container) {
        return new DoctrineFlusher(
            $container->get(EntityManagerInterface::class),
            $container->get(EventDispatcher::class)
        );
    },
    DoctrineDomainRepository::class => function(ContainerInterface $container) {
        return new DoctrineDomainRepository(
            $container->get(EntityManagerInterface::class)
        );
    },
    \App\Model\Domain\UseCase\Index\Handler::class => function(ContainerInterface $container) {
        return new \App\Model\Domain\UseCase\Index\Handler(
            $container->get(\App\Model\Domain\Entity\DomainRepository::class)
        );
    },
    \App\Model\Domain\Entity\DomainRepository::class => function(ContainerInterface $container) {
        return new DoctrineDomainRepository($container->get(EntityManagerInterface::class));
    },
];
