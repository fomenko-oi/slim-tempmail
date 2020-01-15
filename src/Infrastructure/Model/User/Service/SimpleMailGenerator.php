<?php

namespace App\Infrastructure\Model\User\Service;

use App\Model\Domain\Entity\DomainRepository;
use App\Model\User\Service\InboxNameGenerator;
use App\Model\User\Service\MailGenerator;

class SimpleMailGenerator implements MailGenerator
{
    /**
     * @var DomainRepository
     */
    private DomainRepository $domains;
    /**
     * @var InboxNameGenerator
     */
    private InboxNameGenerator $nameGenerator;

    public function __construct(DomainRepository $domains, InboxNameGenerator $nameGenerator)
    {
        $this->domains = $domains;
        $this->nameGenerator = $nameGenerator;
    }

    public function randomInbox(): string
    {
        return $this->nameGenerator->generate() . '@' . $this->randomDomain();
    }

    public function randomDomain(): string
    {
        $domain = $this->domains->random();

        return $domain->getHost();
    }
}
