<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain;


interface ValueObject
{
    public function equals(ValueObject $other): bool;
}