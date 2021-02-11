<?php

declare(strict_types=1);

namespace App\Context\Article\Domain;


interface ArticleRepository
{
    public function save(Article $article): void;
}