<?php

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Psr\Container\ContainerInterface;
use App\Infrastructure\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Translator;

return [
    'view' => function(ContainerInterface $container) {
        $loader = new FilesystemLoader('templates');

        $environment =  new Environment($loader, [
            'cache' => 'var/cache/views',
            'debug' => (bool)getenv('API_DEBUG')
        ]);

        $environment->addExtension(new TranslationExtension($container->get(Translator::class)));

        return $environment;
    }
];
