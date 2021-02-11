<?php

declare(strict_types=1);


namespace App\Context\Article\Domain;


use App\Context\Article\Domain\Event\ArticleBodyChanged;
use App\Context\Article\Domain\Event\ArticleCreated;
use App\Context\Article\Domain\Event\ArticleDeleted;
use App\Context\Article\Domain\Event\ArticleTitleChanged;
use App\Context\Shared\Domain\AggregateRoot;

final class Article extends AggregateRoot
{

    private string $title;

    private string $body;

    private \DateTimeImmutable $createdAt;

    private \DateTimeImmutable $updatedAt;

    private bool $deleted = false;

    public function __construct(string $title, string $body, ?ArticleId $id = null)
    {
        $articleId = $id ?? ArticleId::generate();
        $this->recordAndApply(new ArticleCreated($articleId, $title, $body));
    }

    public function getState(): array
    {
        return [
            'id'        => $this->id->value(),
            'body'      => $this->body,
            'title'     => $this->title,
            'deleted'   => $this->deleted,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }

    public function changeTitle(string $newTitle): void
    {
        $this->recordAndApply(new ArticleTitleChanged($this->title, $newTitle));
    }

    public function changeBody(string $newBody): void
    {
        $this->recordAndApply(new ArticleBodyChanged($this->body, $newBody));
    }

    public function delete(): void
    {
        $this->recordAndApply(new ArticleDeleted());
    }

    protected function applyArticleCreated(ArticleCreated $event): void
    {
        $this->id = $event->getId();
        $this->title = $event->getTitle();
        $this->body = $event->getBody();
        $this->createdAt = $this->updatedAt = new \DateTimeImmutable();
    }

    protected function applyArticleTitleChanged(ArticleTitleChanged $event): void
    {
        $this->title = $event->getNewTitle();
        $this->updatedAt = $event->occurredAt();
    }

    protected function applyArticleBodyChanged(ArticleBodyChanged $event): void
    {
        $this->body = $event->getNewBody();
        $this->updatedAt = $event->occurredAt();
    }

    protected function applyArticleDeleted(ArticleDeleted $event): void
    {
        if ($this->deleted) {
            throw new \DomainException(
                sprintf('Could not delete already deleted task with id: "%s"', $this->id->value())
            );
        }
        $this->deleted = true;
        $this->updatedAt = $event->occurredAt();
    }

}