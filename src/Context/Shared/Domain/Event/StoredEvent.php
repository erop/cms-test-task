<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain\Event;


use App\Context\Shared\Domain\AggregateRoot;

class StoredEvent
{
    private int $id;

    private string $aggregateType;

    private string $aggregateId;

    private \DateTimeImmutable $occurredAt;

    private DomainEvent $event;

    private \DateTimeImmutable $appendedAt;

    public function __construct(
        AggregateRoot $aggregate,
        DomainEvent $event
    ) {
        $this->aggregateType = get_class($aggregate);
        $this->aggregateId = $aggregate->id()->value();
        $this->occurredAt = $event->occurredAt();
        $this->event = $event;
        $this->appendedAt = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAggregateType(): string
    {
        return $this->aggregateType;
    }

    public function getAggregateId(): string
    {
        return $this->aggregateId;
    }

    public function getOccurredAt(): \DateTimeImmutable
    {
        return $this->occurredAt;
    }

    public function getEvent(): DomainEvent
    {
        return $this->event;
    }

    public function getAppendedAt(): \DateTimeImmutable
    {
        return $this->appendedAt;
    }

}