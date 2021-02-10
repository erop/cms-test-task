<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain\Event;


use App\Context\Shared\Domain\Event;

abstract class DomainEvent implements Event
{
    protected \DateTimeImmutable $occurredAd;

    public function __construct()
    {
        $this->occurredAd = new \DateTimeImmutable();
    }

    public function occurredAt(): \DateTimeImmutable
    {
        return $this->occurredAd;
    }

}