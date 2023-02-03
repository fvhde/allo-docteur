<?php

declare(strict_types=1);

namespace App\Type\Doctrine;

use App\Entity\ValueObject\GeoPoint;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class GeoPointType extends Type
{
    public const POINT = 'point';

    public function getName()
    {
        return self::POINT;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'POINT';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        list($longitude, $latitude) = sscanf($value, 'POINT(%f %f)');

        return new GeoPoint($latitude, $longitude);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof GeoPoint) {
            $value = sprintf('POINT(%F %F)', $value->getLongitude(), $value->getLatitude());
        }

        return $value;
    }

    public function canRequireSQLConversion(): bool
    {
        return true;
    }

    public function convertToPHPValueSQL($sqlExpr, $platform): string
    {
        return sprintf('ST_AsText(%s)', $sqlExpr);
    }

    public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform): string
    {
        return sprintf('ST_PointFromText(%s)', $sqlExpr);
    }
}
