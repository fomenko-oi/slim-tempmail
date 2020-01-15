<?php

namespace App\Model\Domain\Entity;

interface DomainRepository
{
    public function all();
    public function add(Domain $domain): void;
    public function existsByHost(string $host): bool;
    public function random(): Domain;
}
