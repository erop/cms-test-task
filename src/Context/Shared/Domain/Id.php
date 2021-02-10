<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain;


interface Id
{
    public function value(): string;

    public function equals(Id $other): bool;

    public static function generate(): static;

    public function createFromString(string $value): static;
}