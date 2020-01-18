<?php

namespace App\Model\Email\UseCase\Remove;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $inbox;

    /**
     * @Assert\NotBlank()
     */
    public $messageId;
}

