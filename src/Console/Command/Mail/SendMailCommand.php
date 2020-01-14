<?php

namespace App\Console\Command\Mail;

use App\Service\Email\SenderService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SendMailCommand extends Command
{
    /**
     * @var SenderService
     */
    private SenderService $service;

    public function __construct(SenderService $service)
    {
        $this->service = $service;
        parent::__construct(null);
    }

    protected function configure(): void
    {
        $this
            ->setName('mail:messages:send')
            ->setDescription('Send message to email.')
            ->addArgument('email', InputArgument::REQUIRED)
            ->addArgument('text', InputArgument::REQUIRED)
            ->addOption('attachment', null, InputOption::VALUE_OPTIONAL, 'Attachment')
            ->addOption('subject', null, InputOption::VALUE_OPTIONAL, 'Message subject')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $text = $input->getArgument('text');

        if($attachment = $input->getOption('attachment')) {
            if(!file_exists($attachment)) {
                $output->writeln("<error>Attachment {$attachment} is not exists.</error>");
                return 1;
            }
        }

        $output->writeln("<comment>Send email to '{$email}': {$text}</comment>");

        try {
            $this->service->send($email, $text, $attachment, $input->getOption('subject'));

            $output->writeln('<info>Message successful sent</info>');
        } catch (\Exception $e) {
            $output->writeln("<error>{$e->getMessage()}</error>");

            return 1;
        }

        return 0;
    }
}
