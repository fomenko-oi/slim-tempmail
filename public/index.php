<?php

use Slim\Factory\AppFactory;
use Symfony\Component\Dotenv\Dotenv;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';
if (file_exists('.env')) {
    (new Dotenv())->load('.env');
}

AppFactory::setContainer($container = (require 'config/container.php')->build());

$app = AppFactory::create();

// Define middlewares
(require 'config/middlewares.php.php')($app, $container);
// Define app routes
(require 'config/routes.php')($app, $container);

// Run app
$app->run();
