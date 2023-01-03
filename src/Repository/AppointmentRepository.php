<?php

namespace App\Repository;

use App\Entity\Appointment;
use App\Entity\Client;
use App\Entity\TypeAppointment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Appointment>
 *
 * @method Appointment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appointment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appointment[]    findAll()
 * @method Appointment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppointmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appointment::class);
    }

    public function save(Appointment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Appointment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getAppointmentAt(\DateTime $datetimeStart, TypeAppointment $type, Client $client): Appointment|null
    {
        // add $duration minutes to the start datetime
        $datetimeEnd = (clone $datetimeStart)->add(new \DateInterval("PT{$type->getDuration()}M"));

        // get the appointment if it exists.
        return $this->createQueryBuilder('a')
            ->where('a.client = :client')
            ->andWhere('(:dtStart BETWEEN a.dateApp AND a.dateEnd) OR (:dtEnd BETWEEN a.dateApp AND a.dateEnd)')
            ->getQuery()
            ->setParameter('client', $client)
            ->setParameter('dtStart', $datetimeStart) // define start time.
            ->setParameter('dtEnd', $datetimeEnd) // define end time.
            ->getOneOrNullResult();
    }
}
