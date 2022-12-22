<?php

namespace App\Repository;

use App\Entity\Thread;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Thread>
 *
 * @method Thread|null find($id, $lockMode = null, $lockVersion = null)
 * @method Thread|null findOneBy(array $criteria, array $orderBy = null)
 * @method Thread[]    findAll()
 * @method Thread[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThreadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Thread::class);
    }

    public function save(Thread $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Thread $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Return all thread (id, lib, createdAt) with author in 'name' in one SQL request, this adds a search and pagination param.
     */
    public function findAllWithName(string $search = '', int $page, int $perPage): array
    {
        /* https://www.doctrine-project.org/projects/doctrine-orm/en/latest/tutorials/pagination.html */

        return $this->createQueryBuilder('t')
            ->select('t.id as id')
            ->addSelect('t.lib as lib')
            ->addSelect('t.createdAt as createdAt')
            ->addSelect('t.message as message')
            ->addSelect('t.resolved as resolved')
            ->addSelect('COUNT(replies.id) as count')
            ->addSelect("CONCAT(author.lastName, ' ',author.firstName) as name")
            ->innerJoin('t.author', 'author')
            ->leftJoin('t.replies', 'replies')
            ->where('t.lib LIKE :search OR t.message LIKE :search')
            ->orderBy('t.createdAt', 'DESC')
            ->groupBy('t.id')
            ->setParameter('search', "%$search%")
            ->getQuery()
            ->setFirstResult($page * $perPage)
            ->setMaxResults($perPage)
            ->execute();
    }
}
