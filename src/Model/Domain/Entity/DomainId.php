<?php

namespace App\Model\Domain\Entity;

use Webmozart\Assert\Assert;
use Ramsey\Uuid\Uuid;

class DomainId
{
    private string $id;

    public function __construct(string $id)
    {
        Assert::notEmpty($id);
        $this->id = $id;
    }

    public static function next(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
