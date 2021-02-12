<?php

declare(strict_types=1);

namespace App\Context\Article\Application\Command\Handler;


use App\Context\Article\Application\Command\CreateArticle;
use App\Context\Article\Domain\Article;
use App\Context\Article\Domain\ArticleId;
use App\Context\Article\Infrastructure\ArticleRepository;

class CreateArticleHandler
{
    private ArticleRepository $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateArticle $command): void
    {
        $articleId = (null === $id = $command->id) ? ArticleId::generate() : ArticleId::createFromString($id);
        $article = new Article($command->title, $command->body, $articleId);
        $this->repository->save($article);
    }
}