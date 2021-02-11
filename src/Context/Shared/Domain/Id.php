<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain;


interface Id
{
    public function value(): string;

    public function equals(Id $other): bool;

    public static function generate(): Id;

    public static function createFromString(string $value): Id;
}