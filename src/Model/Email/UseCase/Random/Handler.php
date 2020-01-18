<?php

namespace App\Model\Email\UseCase\Random;

use App\Model\User\Entity\UserProvider;
use App\Model\User\Service\MailGenerator;

class Handler
{
    /**
     * @var UserProvider
     */
    private UserProvider $userProvider;
    /**
     * @var MailGenerator
     */
    private MailGenerator $mailGenerator;

    public function __construct(MailGenerator $mailGenerator, UserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
        $this->mailGenerator = $mailGenerator;
    }

    public function handle(): string
    {
        $this->userProvider->setEmail($email = $this->mailGenerator->randomInbox());

        return $email;
    }
}
