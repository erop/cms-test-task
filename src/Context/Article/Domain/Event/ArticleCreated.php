<?php


namespace App\Context\Article\Domain\Event;


use App\Context\Article\Domain\ArticleId;
use App\Context\Shared\Domain\Event\DomainEvent;

final class ArticleCreated extends DomainEvent
{
    private ArticleId $id;

    private string $title;

    private string $body;

    public function __construct(ArticleId $id, string $title, string $body)
    {
        parent::__construct();
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
    }

    public function getId(): ArticleId
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }


}