<?php

namespace App\Repository;

use App\Entity\Agenda;
use App\Entity\Appointment;
use App\Entity\Client;
use App\Entity\TypeAppointment;
use App\Entity\Veto;
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
    public function getAppointmentAt(\DateTime $datetimeStart, TypeAppointment $type, Veto $veto): Appointment|null
    {
        // add $duration minutes to the start datetime
        $datetimeEnd = (clone $datetimeStart)->add(new \DateInterval("PT{$type->getDuration()}M"));

        // get the appointment if it exists.
        return $this->createQueryBuilder('a')
            ->where('a.veto = :veto')
            ->andWhere('(:dtStart BETWEEN a.dateApp AND a.dateEnd) OR (:dtEnd BETWEEN a.dateApp AND a.dateEnd)')
            ->getQuery()
            ->setParameter('veto', $veto)
            ->setParameter('dtStart', $datetimeStart) // define start time.
            ->setParameter('dtEnd', $datetimeEnd) // define end time.
            ->getOneOrNullResult();
    }

    public function findByVetoOnWeek(Veto $veto, int $weekOffset = 0): array
    {
        $start_week = date('Y-m-d', date_modify(new \DateTime('monday this week'), "+{$weekOffset} week")->getTimestamp());
        $end_week = date('Y-m-d', date_modify(new \DateTime('sunday this week'), "+{$weekOffset} week")->getTimestamp());

        return $this->createQueryBuilder('a')
            ->where('a.veto = :veto')
            ->andWhere('a.dateApp >= :start')
            ->andWhere('a.dateApp <= :end')
            ->getQuery()
            ->setParameter('veto', $veto)
            ->setParameter('start', $start_week)
            ->setParameter('end', $end_week)
            ->getArrayResult();
    }
}
