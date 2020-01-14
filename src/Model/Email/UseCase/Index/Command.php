<?php

namespace App\Model\Email\UseCase\Index;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $email;
}

