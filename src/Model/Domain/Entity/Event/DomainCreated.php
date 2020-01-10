<?php

namespace App\Model\Domain\Entity\Event;

use App\Model\Domain\Entity\DomainId;

class DomainCreated
{
    public string $id;
    public string $domain;

    public function __construct(DomainId $id, string $domain)
    {
        $this->id = $id;
        $this->domain = $domain;
    }
}
