<?php

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Psr\Container\ContainerInterface;
use App\Infrastructure\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Translator;

return [
    'view' => function(ContainerInterface $container) {
        $config = $container->get('config');

        $loader = new FilesystemLoader('templates');

        $environment =  new Environment($loader, [
            'cache' => 'var/cache/views',
            'debug' => (bool)getenv('API_DEBUG')
        ]);

        $environment->addExtension(new TranslationExtension($container->get(Translator::class)));

        $user = $container->get(\App\Model\User\Entity\UserProvider::class);
        $lang = $container->get(\App\Model\User\Service\Language\LanguageManager::class);

        $environment->addGlobal('languages', $config['locale']['list']);
        $environment->addGlobal('user_email', $user->getEmail());
        $environment->addGlobal('lang', $lang->get());

        return $environment;
    }
];
