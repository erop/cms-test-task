<?php

declare(strict_types=1);

namespace App\Context\Article\Domain\Event;


use App\Context\Shared\Domain\Event\DomainEvent;

final class ArticleBodyChanged extends DomainEvent
{
    private string $oldBody;

    private string $newBody;

    public function __construct(string $oldBody, string $newBody)
    {
        parent::__construct();
        $this->oldBody = $oldBody;
        $this->newBody = $newBody;
    }

    public function getOldBody(): string
    {
        return $this->oldBody;
    }

    public function getNewBody(): string
    {
        return $this->newBody;
    }

}