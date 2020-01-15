<?php

use App\Infrastructure\Doctrine\Type;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\DBAL;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;
use App\Infrastructure\Doctrine\Functions\Rand;

return [
    EntityManagerInterface::class => function (ContainerInterface $container) {
        $params = $container->get('config')['doctrine'];

        $config = Setup::createAnnotationMetadataConfiguration(
            $params['metadata_dirs'],
            $params['dev_mode'],
            $params['cache_dir'],
            new FilesystemCache(
                $params['cache_dir']
            ),
            false
        );

        $config->addCustomNumericFunction('Rand', Rand::class);

        foreach ($params['types'] as $type => $class) {
            if (!DBAL\Types\Type::hasType($type)) {
                DBAL\Types\Type::addType($type, $class);
            }
        }
        return EntityManager::create(
            $params['connection'],
            $config
        );
    },
    'config' => [
        'doctrine' => [
            'dev_mode' => false,
            'cache_dir' => 'var/cache/doctrine',
            'metadata_dirs' => [
                'src/Model/Domain/Entity',
                'src/Model/Email/Entity',
            ],
            'connection' => [
                'url' => getenv('API_DB_URL'),
            ],
            'types' => [
                Type\Domain\DomainIdType::NAME => Type\Domain\DomainIdType::class,
                Type\Email\EmailIdType::NAME => Type\Email\EmailIdType::class,
                Type\Domain\DomainTypeType::NAME => Type\Domain\DomainTypeType::class,
            ],
        ],
    ],
];
