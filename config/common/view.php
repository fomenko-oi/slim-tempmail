<?php

return [
    'view' => function() {
        $loader = new \Twig\Loader\FilesystemLoader('templates');

        return new \Twig\Environment($loader, [
            'cache' => 'var/cache/views',
            'debug' => (bool)getenv('API_DEBUG')
        ]);
    }
];
