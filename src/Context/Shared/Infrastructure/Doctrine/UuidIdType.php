<?php

declare(strict_types=1);

namespace App\Context\Shared\Infrastructure\Doctrine;


use App\Context\Shared\Domain\UuidId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

abstract class UuidIdType extends Type
{
    protected const NAME = '';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }
        if ($value instanceof UuidId) {
            return $value->value();
        }
        throw ConversionException::conversionFailed($value, static::NAME);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }
        $className = $this->className();
        if ( ! is_subclass_of($className, UuidId::class)) {
            throw new \LogicException(
                sprintf('Given class name "%s" is NOT a subclass of "%s"', $className, UuidId::class)
            );
        }
        return $className::createFromString((string)$value);
    }

    abstract protected function className(): string;

}