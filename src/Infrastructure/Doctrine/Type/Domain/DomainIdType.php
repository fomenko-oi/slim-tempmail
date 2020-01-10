<?php

namespace App\Infrastructure\Doctrine\Type\Domain;

use App\Model\Domain\Entity\DomainId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class DomainIdType extends GuidType
{
    public const NAME = 'domain_id';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof DomainId ? $value->getId() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new DomainId($value) : null;
    }

    public function getName(): string {
        return self::NAME;
    }
}
