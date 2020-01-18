<?php

use Psr\Container\ContainerInterface;
use App\Model\User\Service\Language\LanguageManager as LanguageManagerInterface;
use App\Infrastructure\Model\User\Service\Language\LanguageManger;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\PhpFileLoader;

return [
    Translator::class => function(ContainerInterface $container) {
        $params = $container->get('config')['locale'];

        $translator = new Translator(
            $params['default'],
            null,
            $params['cache_dir'],
            (bool)getenv('API_DEBUG')
        );

        $translator->setFallbackLocales([$params['default']]);

        $translator->addLoader('file', new PhpFileLoader());

        array_map(function($lang) use ($translator) {
            $translator->addResource('file', "translations/{$lang}.php", $lang);
        }, $params['list']);

        return $translator;
    },
    LanguageManagerInterface::class => function(ContainerInterface $container) {
        $params = $container->get('config')['locale'];

        return new LanguageManger(
            $params['list'],
            $params['default'],
            $container->get(Translator::class)
        );
    },

    'config' => [
        'locale' => [
            'list' => ['en', 'ru', 'ua'],
            'default' => 'en',
            'translations_dir' => 'translations',
            'cache_dir' => 'var/cache/translations'
        ]
    ]
];
