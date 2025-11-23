<?php

namespace App\Repository;

use App\Entity\Carpooling;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Carpooling>
 */
class CarpoolingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carpooling::class);
    }
    public function searchCarpoolings($depart, $arrivee, $date, $prixMax, $eco)
{
    $qb = $this->createQueryBuilder('c');

    if ($depart) {
        $qb->andWhere('LOWER(c.departure) LIKE :depart')
           ->setParameter('depart', '%' . strtolower($depart) . '%');
    }

    if ($arrivee) {
        $qb->andWhere('LOWER(c.arrival) LIKE :arrivee')
           ->setParameter('arrivee', '%' . strtolower($arrivee) . '%');
    }

    if ($date) {
        $start = new \DateTime($date . ' 00:00:00');
        $end   = new \DateTime($date . ' 23:59:59');

        $qb->andWhere('c.departureAt BETWEEN :start AND :end')
           ->setParameter('start', $start)
           ->setParameter('end', $end);
    }

    if ($prixMax) {
        $qb->andWhere('c.price <= :prix')
           ->setParameter('prix', $prixMax);
    }

    if ($eco === "1") {
        $qb->andWhere('c.isEcoTrip = 1');
    }

    return $qb->getQuery()->getResult();
}


    //    /**
    //     * @return Carpooling[] Returns an array of Carpooling objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Carpooling
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
