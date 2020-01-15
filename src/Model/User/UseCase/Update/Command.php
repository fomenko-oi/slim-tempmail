<?php

namespace App\Model\User\UseCase\Update;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $host;
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="2")
     */
    public $login;
}
