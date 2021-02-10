<?php

declare(strict_types=1);

namespace App\Context\Article\Domain\Event;


use App\Context\Shared\Domain\Event\DomainEvent;

final class ArticleTitleChanged extends DomainEvent
{
    private string $oldTitle;

    private string $newTitle;

    public function __construct(string $oldTitle, string $newTitle)
    {
        parent::__construct();
        $this->oldTitle = $oldTitle;
        $this->newTitle = $newTitle;
    }

    public function getOldTitle(): string
    {
        return $this->oldTitle;
    }

    public function getNewTitle(): string
    {
        return $this->newTitle;
    }

}