#!/usr/bin/env php
<?php
declare(strict_types=1);
use Doctrine\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;
use Doctrine\Migrations\Configuration\Configuration;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';
if (file_exists('.env')) {
    (new Dotenv())->load('.env');
}
/**
 * @var \Psr\Container\ContainerInterface $container
 */
$container = (require 'config/container.php')->build();
$cli = new Application('Application console');
$entityManager = $container->get(Doctrine\ORM\EntityManagerInterface::class);

dd($entityManager);
die;

$connection = $entityManager->getConnection();
$configuration = new Configuration($connection);
$configuration->setMigrationsDirectory('src/Data/Migration');
$configuration->setMigrationsNamespace('App\Data\Migration');
$cli->getHelperSet()->set(new EntityManagerHelper($entityManager), 'em');
$cli->getHelperSet()->set(new ConfigurationHelper($connection, $configuration), 'configuration');
Doctrine\ORM\Tools\Console\ConsoleRunner::addCommands($cli);
\Doctrine\Migrations\Tools\Console\ConsoleRunner::addCommands($cli);
$commands = $container->get('config')['console']['commands'];
foreach ($commands as $command) {
    $cli->add($container->get($command));
}
$cli->run();
