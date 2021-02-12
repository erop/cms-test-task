<?php

declare(strict_types=1);

namespace App\Tests\Functional\Context\Article\Infrastructure;


use App\Context\Shared\Domain\AggregateRoot;
use App\Context\Shared\Domain\Event\DomainEvent;
use App\Context\Shared\Domain\Event\EventStore;

class InMemoryEventStore implements EventStore
{
    private array $events = [];

    public function append(DomainEvent $event, AggregateRoot $aggregate): void
    {
        $aggregateType = get_class($aggregate);
        $aggregateId = $aggregate->id()->value();
        $this->events[$aggregateType][$aggregateId][] = $event;
    }

    public function allEventsSince(AggregateRoot $aggregate, ?\DateTimeImmutable $start = null)
    {
        $aggregateType = get_class($aggregate);
        $aggregateId = $aggregate->id()->value();

        $allEvents = $this->events[$aggregateType][$aggregateId];
        if (null !== $start) {
            return array_filter(
                $allEvents,
                static function (DomainEvent $event) use ($start) {
                    return $event->occurredAt() >= $start;
                }
            );
        }
        return $allEvents;
    }
}