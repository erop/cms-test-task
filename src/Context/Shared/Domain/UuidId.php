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

    public static function generate(): static
    {
        return new static(Uuid::uuid4()->toString());
    }

    public function createFromString(string $value): static
    {
        return new static($value);
    }

    public function equals(Id $other): bool
    {
        return $this::class === $other::class && $this->value() === $other->value();
    }

    public function value(): string
    {
        return $this->value;
    }
}