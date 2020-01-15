<?php

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Validator\Validation;
use Slim\Middleware\Session;
use Psr\Container\ContainerInterface;
use App\Http\Middleware\UserEmailMiddleware;
use App\Model\User\Entity\UserProvider;
use App\Model\User\Service\MailGenerator;

return [
    ValidatorInterface::class => function () {
        AnnotationRegistry::registerLoader('class_exists');
        return Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
    },
    Session::class => function(ContainerInterface $container) {
        return new Session([
            'name' => 'session',
            'autorefresh' => true,
            'lifetime' => '1 hour'
        ]);
    },
    'session' => function(ContainerInterface $container) {
        return new \SlimSession\Helper();
    },
    UserEmailMiddleware::class => function(ContainerInterface $container) {
        return new UserEmailMiddleware(
            $container->get(UserProvider::class),
            $container->get(MailGenerator::class)
        );
    },
];
