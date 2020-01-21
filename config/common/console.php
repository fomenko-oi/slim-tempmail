<?php

use Psr\Container\ContainerInterface;
use App\Console\Command;
use App\Service\Email\ReceiverService;
use App\Service\Email\SenderService;
use PhpAmqpLib\Connection\AMQPStreamConnection;

return [
    Command\Mail\IncomingCheckCommand::class => function(ContainerInterface $container) {
        return new Command\Mail\IncomingCheckCommand($container->get(ReceiverService::class));
    },
    Command\Mail\SendMailCommand::class => function(ContainerInterface $container) {
        return new Command\Mail\SendMailCommand($container->get(SenderService::class));
    },
    Command\Amqp\ProduceCommand::class => function (ContainerInterface $container) {
        return new Command\Amqp\ProduceCommand(
            $container->get(AMQPStreamConnection::class)
        );
    },
    Command\Amqp\ConsumeCommand::class => function (ContainerInterface $container) {
        return new Command\Amqp\ConsumeCommand(
            $container->get(AMQPStreamConnection::class)
        );
    },

    'config' => [
        'console' => [
            'commands' => [
                Command\Mail\IncomingCheckCommand::class,
                Command\Mail\SendMailCommand::class,
                Command\Amqp\ProduceCommand::class,
                Command\Amqp\ConsumeCommand::class,
            ],
        ],
    ],
];
