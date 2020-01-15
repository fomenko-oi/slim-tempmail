<?php

namespace App\Infrastructure\Model\User\Entity;

use App\Model\User\Entity\UserProvider;
use SlimSession\Helper;

class SessionUserProvider implements UserProvider
{
    const EMAIL_KEY = 'email';

    /**
     * @var Helper
     */
    private Helper $sessionHelper;

    public function __construct(Helper $sessionHelper)
    {
        $this->sessionHelper = $sessionHelper;
    }

    public function setEmail(string $email): void
    {
        $this->sessionHelper->set(self::EMAIL_KEY, $email);
    }

    public function getEmail(): string
    {
        return $this->sessionHelper->get(self::EMAIL_KEY);
    }

    public function hasEmail(): bool
    {
        return $this->sessionHelper->exists(self::EMAIL_KEY);
    }
}
