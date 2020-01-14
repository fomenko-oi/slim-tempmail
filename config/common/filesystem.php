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

    'config' => [
        'filesystem' => [
            'driver' => 'local',
            'url' => 'http://localhost:8083/'
        ]
    ]
];
