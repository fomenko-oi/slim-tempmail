<?php

namespace App\Model\Domain\UseCase\Create;

use App\Model\Domain\Entity\Domain;
use App\Model\Domain\Entity\DomainId;
use App\Model\Domain\Entity\DomainRepository;
use App\Model\Flusher;

class Handler
{
    /**
     * @var DomainRepository
     */
    private DomainRepository $domains;
    /**
     * @var Flusher
     */
    private Flusher $flusher;

    public function __construct(DomainRepository $domainRepository, Flusher $flusher)
    {
        $this->domains = $domainRepository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command)
    {
        if($this->domains->existsByHost($command->host)) {
            throw new \InvalidArgumentException('Domain with the host is already exists.');
        }

        $domain = new Domain(
            DomainId::next(),
            $command->host
        );

        $this->domains->add($domain);
        $this->flusher->flush();
    }
}
