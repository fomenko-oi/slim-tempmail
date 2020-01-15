<?php

use League\Flysystem\FilesystemInterface;
use Psr\Container\ContainerInterface;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

return [
    FilesystemInterface::class => function(ContainerInterface $container) {
        $config = $container->get('config')['filesystem'];
        $driver = $config['driver'];

        switch ($driver) {
            case 'local': $adapter = new Local('storage/public'); break;
            default: throw new \InvalidArgumentException("Unable to handle filesystem driver {$driver}.");
        }

        return new Filesystem($adapter);
    },

    \App\Infrastructure\Storage\UrlGenerator::class => function(ContainerInterface $container) {
        $config = $container->get('config')['filesystem'];

        return new \App\Infrastructure\Storage\UrlGenerator($config['url']);
    },

    'config' => [
        'filesystem' => [
            'driver' => getenv('FILESYSTEM_DRIVER') ?? 'local',
            'url' => getenv('FILESYSTEM_URL'),
        ]
    ]
];
