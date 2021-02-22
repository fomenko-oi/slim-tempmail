<?php

namespace App\Console\Command\Mail;

use App\Service\Email\ReceiverService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IncomingCheckCommand extends Command
{
    /**
     * @var ReceiverService
     */
    private ReceiverService $service;

    public function __construct(ReceiverService $service)
    {
        $this->service = $service;
        parent::__construct(null);
    }

    protected function configure(): void
    {
        $this
            ->setName('mail:messages:handle')
            ->setDescription('Handle all incoming messages, save to DB, and trigger events.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<comment>Begin the process</comment>');

        while(true) {
            $count = $this->service->saveUnseenMessages();

            if($count > 0) {
                $output->writeln('<comment>Total handled '.$count.' messages</comment>');
            }

            usleep(500000);
        }

        $output->writeln("<comment>Finish the process. Total handled {$count} messages.</comment>");

        return 0;
    }
}
