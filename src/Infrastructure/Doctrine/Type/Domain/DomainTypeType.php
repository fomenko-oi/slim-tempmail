<?php

namespace App\Infrastructure\Doctrine\Type\Domain;

use App\Model\Domain\Entity\DomainId;
use App\Model\Domain\Entity\DomainType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class DomainTypeType extends GuidType
{
    public const NAME = 'domain_type';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof DomainType ? $value->getType() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new DomainType($value) : null;
    }

    public function getName(): string {
        return self::NAME;
    }
}
