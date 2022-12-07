<?php

namespace App\Repository;

use App\Entity\Thread;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Tools\Pagination\Paginator;
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
     * Return all thread (id, lib, createdAt) with author in 'name' in one SQL request.
     *
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findAllWithName(int $page, int $perPage): array
    {
        /*https://www.doctrine-project.org/projects/doctrine-orm/en/latest/tutorials/pagination.html*/

        return $this->createQueryBuilder('t')
            ->select('t.id as id')
            ->addSelect('t.lib as lib')
            ->addSelect('t.createdAt as createdAt')
            ->addSelect('t.message as message')
            ->addSelect('COUNT(replies.id) as count')
            ->addSelect("CONCAT(author.lastName, ' ',author.firstName) as name")
            ->innerJoin('t.author', 'author')
            ->innerJoin('t.replies', 'replies')
            ->orderBy('t.createdAt', 'DESC')
            ->groupBy('t.id')
            ->getQuery()
            ->setFirstResult($page * $perPage)
            ->setMaxResults($perPage)
            ->execute();
    }

//    /**
//     * @return Thread[] Returns an array of Thread objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Thread
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
