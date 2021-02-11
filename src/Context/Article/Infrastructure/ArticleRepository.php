<?php

declare(strict_types=1);

namespace App\Context\Article\Infrastructure;


use App\Context\Article\Domain\Article;
use App\Context\Article\Domain\ArticleRepository as ArticleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\UnitOfWork;
use Doctrine\Persistence\ManagerRegistry;

class ArticleRepository extends ServiceEntityRepository implements ArticleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function save(Article $article): void
    {
        if ($this->isNew($article)) {
            $this->_em->persist($article);
        }
        $this->_em->flush();
    }

    private function isNew(Article $article): bool
    {
        return UnitOfWork::STATE_NEW === $this->_em->getUnitOfWork()->getEntityState($article);
    }
}