<?php

declare(strict_types=1);

namespace App\Tests\Functional\Context\Article\Infrastructure;


use App\Context\Article\Domain\Article;
use App\Context\Article\Domain\ArticleRepository;

class InMemoryArticleRepository implements ArticleRepository
{
    private array $articles = [];

    public function save(Article $article): void
    {
        $this->articles[$article->id()->value()] = $article;
    }

    public function find(Article $article): ?Article
    {
        return $this->articles[$article->id()->value()] ?? null;
    }

    public function findAll(): array
    {
        return $this->articles;
    }
}