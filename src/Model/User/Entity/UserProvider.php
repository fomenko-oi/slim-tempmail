<?php

namespace App\Model\User\Entity;

interface UserProvider
{
    public function setEmail(string $email): void;
    public function getEmail(): string;
    public function hasEmail(): bool;
}
