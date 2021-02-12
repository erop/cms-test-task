<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain\Event;


use App\Context\Shared\Domain\AggregateRoot;

interface EventStore
{
    public function append(DomainEvent $event, AggregateRoot $aggregate);

    public function allEventsSince(AggregateRoot $aggregate, ?\DateTimeImmutable $start = null);
}