<?php

namespace App\Console\Command\Amqp;

use App\Infrastructure\Amqp\AMQPHelper;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitCommand extends Command
{
    private $connection;

    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('amqp:init');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<comment>Init '.AMQPHelper::QUEUE_NOTIFICATIONS.' channel</comment>');

        $connection = $this->connection;

        $channel = $connection->channel();

        try {
            AMQPHelper::initNotifications($channel);
            AMQPHelper::registerShutdown($connection, $channel);

            $output->writeln('<info>Done!</info>');

            return 0;
        } catch (\Exception $e) {
            $output->writeln('<error>'.$e->getMessage().'</error>');
            return 1;
        }
    }
}
