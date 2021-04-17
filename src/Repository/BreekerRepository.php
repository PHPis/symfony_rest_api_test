<?php

namespace App\Repository;

use App\Entity\Breeker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Breeker|null find($id, $lockMode = null, $lockVersion = null)
 * @method Breeker|null findOneBy(array $criteria, array $orderBy = null)
 * @method Breeker[]    findAll()
 * @method Breeker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BreekerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Breeker::class);
    }

    // /**
    //  * @return Breeker[] Returns an array of Breeker objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Breeker
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
