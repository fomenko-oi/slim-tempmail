<?php

namespace App\Model\Email\UseCase\Source;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id;
}

