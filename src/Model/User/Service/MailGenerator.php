<?php

namespace App\Model\User\Service;

interface MailGenerator
{
    public function randomInbox(): string;
    public function randomDomain(): string;
}
