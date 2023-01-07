<?php

namespace App\Repository;

use App\Entity\Agenda;
use App\Entity\TypeAppointment;
use App\Entity\Unavailability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Unavailability>
 *
 * @method Unavailability|null find($id, $lockMode = null, $lockVersion = null)
 * @method Unavailability|null findOneBy(array $criteria, array $orderBy = null)
 * @method Unavailability[]    findAll()
 * @method Unavailability[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnavailabilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Unavailability::class);
    }

    public function save(Unavailability $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Unavailability $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Count in the database with a criteria.
     *
     * @see https://stackoverflow.com/questions/19103699/doctrine-counting-an-entitys-items-with-a-condition
     */
    public function countBy(array $criteria): int
    {
        $persister = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName);

        return $persister->count($criteria);
    }

//    /**
//     * @return Unavailability[] Returns an array of Unavailability objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Unavailability
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function getUnavailabilityAt(\DateTime $start, TypeAppointment $type, Agenda $agenda): Unavailability|null
    {
        $end = (clone $start)->add(new \DateInterval("PT{$type->getDuration()}M"));

        return $this->createQueryBuilder('u')
            ->where('u.agenda = :agenda')
            ->andWhere('(:start BETWEEN u.dateDeb AND u.dateEnd) OR (:end NOT BETWEEN u.dateDeb AND u.dateEnd)')
            ->getQuery()
            ->setParameter('agenda', $agenda)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getOneOrNullResult();
    }
}
