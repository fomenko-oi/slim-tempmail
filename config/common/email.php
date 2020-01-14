<?php

use Ddeboer\Imap\Server;
use App\Service\Email\ReceiverService;
use Psr\Container\ContainerInterface;
use App\Service\Email\SenderService;
use App\Model\Email\Entity\MessageRepository;
use App\Model\Flusher;
use League\Flysystem\FilesystemInterface;

return [
    ReceiverService::class => function(ContainerInterface $container) {
        return new ReceiverService(
            $container->get(Server::class),
            $container->get(MessageRepository::class),
            $container->get(Flusher::class),
            $container->get(FilesystemInterface::class)
        );
    },
    SenderService::class => function(ContainerInterface $container) {
        return new SenderService($container->get(Swift_Mailer::class));
    },

    Swift_Mailer::class => function (ContainerInterface $container) {
        $config = $container->get('config')['mailer'];
        $transport = (new Swift_SmtpTransport($config['host'], $config['port']))
            ->setUsername($config['username'])
            ->setPassword($config['password'])
            ->setEncryption($config['encryption']);

        return new Swift_Mailer($transport);
    },

    // IMAP mail client
    Server::class => function(ContainerInterface $container) {
        $config = $container->get('config')['email'];

        $server = new Server(
            $config['host'],
            $config['port'],
            getenv('MAIL_SERVER_URL') ?? '/imap/ssl/novalidate-cert'
        );

        return $server->authenticate($config['username'], $config['password']);
    },

    'config' => [
        'email' => [
            'host' => getenv('MAIL_SERVER_HOST'),
            'port' => (int)getenv('MAIL_SERVER_PORT'),
            'username' => getenv('MAIL_SERVER_USERNAME'),
            'password' => getenv('MAIL_SERVER_PASSWORD'),
            'attachment_dir' => 'public/attachments',
        ],
        'mailer' => [
            'host' => getenv('MAILER_HOST'),
            'port' => (int)getenv('MAILER_PORT'),
            'username' => getenv('MAILER_USERNAME'),
            'password' => getenv('MAILER_PASSWORD'),
            'encryption' => getenv('MAILER_ENCRYPTION'),
            'from' => [getenv('MAILER_FROM_EMAIL') => 'App'],
            'notification_email' => getenv('ADMIN_NOTIFICATION_EMAIL')
        ],
    ],
];
