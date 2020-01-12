<?php

namespace App\Model\Domain\UseCase\Index;

use App\Model\Domain\Entity\Domain;
use App\Model\Domain\Entity\DomainRepository;

class Handler
{
    /**
     * @var DomainRepository
     */
    private DomainRepository $domains;

    public function __construct(DomainRepository $domainRepository)
    {
        $this->domains = $domainRepository;
    }

    public function handle()
    {
        $domains = $this->domains->all();

        return array_map(function(Domain $domain) {
            return [
                'host' => $domain->getHost(),
            ];
        }, $domains);
    }
}
