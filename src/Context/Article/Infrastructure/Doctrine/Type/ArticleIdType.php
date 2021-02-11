<?php

declare(strict_types=1);

namespace App\Context\Article\Infrastructure\Doctrine\Type;


use App\Context\Article\Domain\ArticleId;
use App\Context\Shared\Infrastructure\Doctrine\UuidIdType;

class ArticleIdType extends UuidIdType
{
    protected const NAME = 'ArticleId';

    protected function className(): string
    {
        return ArticleId::class;
    }
}