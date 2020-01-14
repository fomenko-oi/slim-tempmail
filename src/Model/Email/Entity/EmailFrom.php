<?php

namespace App\Model\Email\Entity;

use Webmozart\Assert\Assert;

class EmailFrom
{
    /**
     * @var string
     */
    private string $address;

    public function __construct(string $address)
    {
        Assert::notEmpty($address);

        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }
}
