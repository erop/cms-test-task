<?php

declare(strict_types=1);

namespace App\Context\Shared\Infrastructure;


use App\Context\Shared\Domain\AggregateRoot;
use App\Context\Shared\Domain\Event\DomainEvent;
use App\Context\Shared\Domain\Event\EventStore;
use App\Context\Shared\Domain\Event\StoredEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EventStoreRepository extends ServiceEntityRepository implements EventStore
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoredEvent::class);
    }

    public function append(DomainEvent $event, AggregateRoot $aggregate)
    {
        $this->_em->persist(new StoredEvent($aggregate, $event));
    }

    public function allEventsSince(AggregateRoot $aggregate, ?\DateTimeImmutable $start = null)
    {
    }
}