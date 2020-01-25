<?php

namespace App\Console\Command\Mail;

use App\Http\Validator\Validator;
use App\Model\Domain\UseCase\Create\Handler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDomainCommand extends Command
{
    /**
     * @var Validator
     */
    private Validator $validator;
    /**
     * @var Handler
     */
    private Handler $handler;

    public function __construct(Validator $validator, Handler $handler)
    {
        $this->validator = $validator;
        $this->handler = $handler;
        parent::__construct(null);
    }

    protected function configure(): void
    {
        $this
            ->setName('mail:domain:create')
            ->setDescription('Create new domain.')
            ->addArgument('host', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = new \App\Model\Domain\UseCase\Create\Command();
        $command->host = $input->getArgument('host') ?? null;

        if ($errors = $this->validator->validate($command)) {
            $output->writeln('<error>'. $errors->toArray() .'</error>');
            return 0;
        }

        $this->handler->handle($command);

        $output->writeln("<comment>Domain {$command->host} created</comment>");

        return 0;
    }
}
