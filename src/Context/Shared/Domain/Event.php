<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain;


interface Event
{
    public function occurredAt(): \DateTimeImmutable;
}