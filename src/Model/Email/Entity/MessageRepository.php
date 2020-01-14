<?php

namespace App\Model\Email\Entity;

interface MessageRepository
{
    public function findByHost(string $host);
    public function findByAddress(string $host, string $login);
    public function add(EmailMessage $message): void;
}
