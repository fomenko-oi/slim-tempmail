<?php

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Validator\Validation;
use Slim\Middleware\Session;
use Psr\Container\ContainerInterface;

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
    $container->set('session', function () {
        return new \SlimSession\Helper();
    })
];
