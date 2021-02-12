<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain;


use App\Context\Shared\Domain\Event\DomainEvent;

abstract class AggregateRoot implements Entity
{
    protected UuidId $id;

    protected array $events = [];

    public function id(): UuidId
    {
        return $this->id;
    }

    /**
     * @return array|DomainEvent[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }

    protected function recordAndApply(DomainEvent $event): void
    {
        $this->record($event);
        $this->apply($event);
    }

    protected function record(DomainEvent $event): void
    {
        $this->events[] = $event;
    }

    protected function apply(DomainEvent $event): void
    {
        $eventClass = (new \ReflectionClass($event))->getShortName();
        $method = 'apply' . $eventClass;
        $this->$method($event);
    }

}