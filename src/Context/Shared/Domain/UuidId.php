<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain;


use Ramsey\Uuid\Uuid;

abstract class UuidId implements Id
{
    protected string $value;

    private function __construct(string $value = null)
    {
        if (null === $value) {
            $this->value = Uuid::uuid4()->toString();
        } elseif (Uuid::isValid($value)) {
            $this->value = $value;
        } else {
            throw new \LogicException(sprintf('Not valid UUID provided: "%s"', $value));
        }
    }

    /**
     * @return static
     */
    public static function generate(): Id
    {
        return new static(Uuid::uuid4()->toString());
    }

    /**
     * @return static
     */
    public static function createFromString(string $value): Id
    {
        return new static($value);
    }

    public function equals(Id $other): bool
    {
        return get_class($this) === get_class($other) && $this->value() === $other->value();
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }


}