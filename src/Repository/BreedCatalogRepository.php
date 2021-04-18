<?php

namespace App\Repository;

use App\Entity\BreedCatalog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BreedCatalog|null find($id, $lockMode = null, $lockVersion = null)
 * @method BreedCatalog|null findOneBy(array $criteria, array $orderBy = null)
 * @method BreedCatalog[]    findAll()
 * @method BreedCatalog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BreedCatalogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BreedCatalog::class);
    }

    public function findByType($type)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.type = :val')
            ->setParameter('val', $type)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return BreedCatalog[] Returns an array of BreedCatalog objects
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
    public function findOneBySomeField($value): ?BreedCatalog
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
