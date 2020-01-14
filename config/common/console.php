<?php

use Psr\Container\ContainerInterface;
use App\Console\Command;
use App\Service\Email\ReceiverService;
use App\Service\Email\SenderService;

return [
    Command\Mail\IncomingCheckCommand::class => function(ContainerInterface $container) {
        return new Command\Mail\IncomingCheckCommand($container->get(ReceiverService::class));
    },
    Command\Mail\SendMailCommand::class => function(ContainerInterface $container) {
        return new Command\Mail\SendMailCommand($container->get(SenderService::class));
    },

    'config' => [
        'console' => [
            'commands' => [
                Command\Mail\IncomingCheckCommand::class,
                Command\Mail\SendMailCommand::class,
            ],
        ],
    ],
];
