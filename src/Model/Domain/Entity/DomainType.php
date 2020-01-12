<?php

namespace App\Model\Domain\Entity;

use Webmozart\Assert\Assert;
use Ramsey\Uuid\Uuid;

class DomainType
{
    const TYPE_COMMON = 'common';
    const TYPE_PRIVATE = 'private'; // owned by user

    private string $type = self::TYPE_COMMON;

    public function __construct(string $type)
    {
        Assert::keyExists(self::getTypesList(), $type);
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isCommon(): bool
    {
        return $this->type === self::TYPE_COMMON;
    }
    public function isPrivate(): bool
    {
        return $this->type === self::TYPE_PRIVATE;
    }

    public function isEqualTo(self $type): bool
    {
        return $this->type === $type->getType();
    }

    public static function private(): self
    {
        return new static(self::TYPE_PRIVATE);
    }
    public static function common(): self
    {
        return new static(self::TYPE_COMMON);
    }

    public static function getTypesList(): array
    {
        return [
            self::TYPE_COMMON => 'Common',
            self::TYPE_PRIVATE => 'Private',
        ];
    }
}
