<?php

declare(strict_types=1);

namespace App\Context\Article\Application\Command;


class CreateArticle
{
    public ?string $id = null;

    public string $title;

    public string $body;

    public function __construct(string $title, string $body, ?string $id = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
    }

}