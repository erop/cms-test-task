<?php

declare(strict_types=1);

namespace App\Tests\Functional\Context\Article\Infrastructure;


use App\Context\Article\Domain\Article;
use App\Context\Article\Domain\ArticleId;
use App\Context\Article\Domain\ArticleRepository;

class InMemoryArticleRepository implements ArticleRepository
{
    private array $articles = [];

    private InMemoryEventStore $eventStore;

    public function __construct(InMemoryEventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function save(Article $article): void
    {
        $this->articles[$article->id()->value()] = $article;
        foreach ($article->releaseEvents() as $event) {
            $this->eventStore->append($event, $article);
        }
    }

    public function find(ArticleId $id): ?Article
    {
        return $this->articles[$id->value()] ?? null;
    }

    public function findAll(): array
    {
        return $this->articles;
    }
}