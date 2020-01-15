<?php

namespace App\Model\User\UseCase\Update;

use App\Model\Domain\Entity\DomainRepository;
use App\Model\Email\Entity\MessageRepository;
use App\Model\User\Entity\UserProvider;
use App\Model\User\UseCase\Update\Command;

class Handler
{
    /**
     * @var DomainRepository
     */
    private DomainRepository $domains;
    /**
     * @var UserProvider
     */
    private UserProvider $userProvider;

    public function __construct(DomainRepository $domains, UserProvider $userProvider)
    {
        $this->domains = $domains;
        $this->userProvider = $userProvider;
    }

    public function handle(Command $command): void
    {
        if(!$this->domains->existsByHost($command->host)) {
            throw new \DomainException("Host {$command->host} is invalid.");
        }

        $this->userProvider->setEmail("{$command->login}@{$command->host}");
    }
}
