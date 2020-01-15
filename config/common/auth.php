<?php

use App\Model\User\Entity\UserProvider;
use Psr\Container\ContainerInterface;
use App\Infrastructure\Model\User\Entity\SessionUserProvider;

return [
    UserProvider::class => function(ContainerInterface $container) {
        return new SessionUserProvider($container->get('session'));
    },
];
