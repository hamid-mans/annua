<?php

namespace App\Repository;

use App\Entity\Vehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicle>
 */
class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function findAllBySearch($company, $search, $statuses): \Doctrine\ORM\QueryBuilder
    {
        $qb = $this->createQueryBuilder('v');

        $escaped = addcslashes(mb_strtolower($search), '%_\\');

        $qb
            ->andWhere('v.company = :company')
            ->andWhere($qb->expr()->orX(
                $qb->expr()->like('LOWER(v.brand)', ':search'),
                $qb->expr()->like('LOWER(v.model)', ':search'),
                $qb->expr()->like('LOWER(v.registrationNumber)', ':search'),
            ))
            ->setParameter('search', '%' . $escaped . '%')
            ->setParameter('company', $company)
            ->orderBy('v.registrationNumber', 'ASC')
            ->addOrderBy('v.brand', 'ASC')
            ->addOrderBy('v.model', 'ASC');

        if ($statuses !== []) {
            $qb->andWhere('v.status IN (:statuses)')
                ->setParameter('statuses', $statuses);
        }

        return $qb;
    }

//    /**
//     * @return Vehicle[] Returns an array of Vehicle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Vehicle
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
