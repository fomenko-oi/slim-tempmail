<?php

namespace App\Model\Email\Entity;

use Webmozart\Assert\Assert;

class EmailTo
{
    /**
     * @var string
     */
    private string $address;
    /**
     * @var string
     */
    private string $host;

    public function __construct(string $address, string $host)
    {
        Assert::email($address);
        Assert::notEmpty($host);

        $this->address = $this->getReceiverLogin($address);
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    protected function getReceiverLogin(string $email): string
    {
        $segments = explode('@', $email);

        return $segments[0];
    }
}
