<?php


namespace App\Tests\Context\Article\Domain;


use App\Context\Article\Domain\Article;
use App\Context\Article\Domain\ArticleId;
use App\Context\Article\Domain\Event\ArticleBodyChanged;
use App\Context\Article\Domain\Event\ArticleCreated;
use App\Context\Article\Domain\Event\ArticleDeleted;
use App\Context\Article\Domain\Event\ArticleTitleChanged;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function testCreateArticle(): void
    {
        $article = new Article('Creating article', 'The article was created', $articleId = ArticleId::generate());
        $event = $article->releaseEvents()[0];
        self::assertInstanceOf(ArticleCreated::class, $event);

        $expected = [
            'id'    => $articleId->value(),
            'title' => 'Creating article',
            'body'  => 'The article was created',
        ];
        $articleState = $article->getState();
        foreach ($expected as $property => $value) {
            self::assertEquals($value, $articleState[$property]);
        }
        self::assertEquals($articleState['createdAt'], $articleState['updatedAt']);
    }

    public function testChangeTitle(): void
    {
        $article = new Article('Creating article', 'The article was created', $articleId = ArticleId::generate());
        $previousState = $article->getState();

        $article->changeTitle('Title was modified');
        $currentState = $article->getState();

        self::assertEquals('Title was modified', $currentState['title']);
        self::assertGreaterThan($previousState['createdAt'], $currentState['updatedAt']);

        $events = $article->releaseEvents();
        $event = end($events);
        self::assertInstanceOf(ArticleTitleChanged::class, $event);
    }

    public function testChangeBody(): void
    {
        $article = new Article('Creating article', 'The article was created', $articleId = ArticleId::generate());
        $previousState = $article->getState();

        $article->changeBody('This is the new body');
        $currentState = $article->getState();

        self::assertEquals('This is the new body', $currentState['body']);
        self::assertGreaterThan($previousState['updatedAt'], $currentState['updatedAt']);
        self::assertEquals($previousState['createdAt'], $currentState['createdAt']);

        $events = $article->releaseEvents();
        $event = end($events);
        self::assertInstanceOf(ArticleBodyChanged::class, $event);
    }

    public function testArticleDeleted(): void
    {
        $article = new Article('Creating article', 'The article was created', $articleId = ArticleId::generate());
        self::assertFalse($article->getState()['deleted']);

        $article->delete();
        $events = $article->releaseEvents();
        self::assertInstanceOf(ArticleCreated::class, $events[0]);
        self::assertInstanceOf(ArticleDeleted::class, $events[1]);
        self::assertTrue($article->getState()['deleted']);
    }
}