<?php

declare(strict_types=1);

namespace App\Context\Article\Infrastructure;


use App\Context\Article\Domain\Article;
use App\Context\Article\Domain\ArticleRepository as ArticleRepositoryInterface;
use App\Context\Shared\Infrastructure\EventStoreRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\UnitOfWork;
use Doctrine\Persistence\ManagerRegistry;

class ArticleRepository extends ServiceEntityRepository implements ArticleRepositoryInterface
{
    /**
     * @var EventStoreRepository
     */
    private EventStoreRepository $eventStoreRepository;

    public function __construct(ManagerRegistry $registry, EventStoreRepository $eventStoreRepository)
    {
        parent::__construct($registry, Article::class);
        $this->eventStoreRepository = $eventStoreRepository;
    }

    public function save(Article $article): void
    {
        $this->_em->transactional(
            function (EntityManagerInterface $em) use ($article) {
                if ($this->isNewEntity($article)) {
                    $em->persist($article);
                }
                foreach ($article->releaseEvents() as $event) {
                   $this->eventStoreRepository->append($event, $article);
                }
            }
        );
    }

    private function isNewEntity(Article $article): bool
    {
        return UnitOfWork::STATE_NEW === $this->_em->getUnitOfWork()->getEntityState($article, UnitOfWork::STATE_NEW);
    }
}