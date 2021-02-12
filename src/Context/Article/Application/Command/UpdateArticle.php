<?php

declare(strict_types=1);

namespace App\Context\Article\Application\Command;


class UpdateArticle
{
    public string $title;

    public string $body;
}