<?php

namespace App\Model\Domain\UseCase\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $host;
}
