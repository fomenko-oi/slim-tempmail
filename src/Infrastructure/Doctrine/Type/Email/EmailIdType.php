<?php

namespace App\Infrastructure\Doctrine\Type\Email;

use App\Model\Email\Entity\EmailId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class EmailIdType extends GuidType
{
    public const NAME = 'email_id';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof EmailId ? $value->getId() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new EmailId($value) : null;
    }

    public function getName(): string {
        return self::NAME;
    }
}
