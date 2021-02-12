<?php

declare(strict_types=1);

namespace App\Tests\Functional\Context\Article\Infrastructure;

use App\Context\Article\Domain\Article;
use App\Context\Article\Domain\ArticleId;
use App\Context\Article\Domain\Event\ArticleCreated;
use PHPUnit\Framework\TestCase;

class ArticleRepositoryTest extends TestCase
{

    public function testSave(): void
    {
        $repo = new InMemoryArticleRepository($eventStore = new InMemoryEventStore());
        $article1 = new Article('First article', 'First article body', ArticleId::generate());
        $article2 = new Article('Second article', 'Second article body', ArticleId::generate());
        $repo->save($article1);
        $repo->save($article2);
        self::assertCount(2, $repo->findAll());
        self::assertCount(1, $events = $eventStore->allEventsSince($article1));
        self::assertInstanceOf(ArticleCreated::class, reset($events));
    }
}
